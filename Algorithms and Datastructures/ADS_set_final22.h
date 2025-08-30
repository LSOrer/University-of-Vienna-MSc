#ifndef ADS_SET_H
#define ADS_SET_H

#include <functional>
#include <algorithm>
#include <iostream>
#include <stdexcept>

template <typename Key, size_t N = 7>
class ADS_set {
public:
  class Iterator;
  using value_type = Key;
  using key_type = Key;
  using reference = value_type &;
  using const_reference = const value_type &;
  using size_type = size_t;
  using difference_type = std::ptrdiff_t;
  using const_iterator = Iterator;
  using iterator = const_iterator;
  //using key_compare = std::less<key_type>;                         // B+-Tree
  using key_equal = std::equal_to<key_type>;                       // Hashing
  using hasher = std::hash<key_type>;                              // Hashing

private:
  struct Element {
    key_type key;
    Element* next {nullptr};

    ~Element() {delete next; };
  };

  struct HashTable {
    Element* begin {nullptr};
    size_type length {0};

    ~HashTable() {delete begin; }
  };
  
  HashTable* chain {nullptr};
  size_type chain_count {0};
  size_type current_size {0};
  float max_lf {0.7};

  size_type h(const key_type &key) const {return hasher{}(key) % chain_count; }
  
  Element* add(const key_type& key) {
    Element *newElem {new Element()};
    newElem->key = key;
    size_type idx {h(key)};
    newElem->next = chain[idx].begin;
    chain[idx].begin = newElem;
    ++chain[idx].length;
    ++current_size;
    return newElem;
  }

  Element* locate(const key_type& key) const {
  size_type idx(h(key));

    if (!chain[idx].length) {
      return nullptr;
    } 
      else {
        Element *tmp{chain[idx].begin};
          while (tmp) {
            if (key_equal{}(tmp->key, key)) {
              return tmp;
            }
            tmp = tmp->next;
          }
          return nullptr;
      } 
  }
  
  void rehash(size_type n) {
    size_type new_chain_count {std::max(N,n)};
    HashTable *old_chain {chain};
    size_type old_chain_count {chain_count};
    chain = nullptr;
    delete[] chain;
    chain = new HashTable[new_chain_count];
    chain_count = new_chain_count;
    current_size = 0;
    Element *tmp {nullptr};

    for (size_type idx {0}; idx < old_chain_count; ++idx) {
      tmp = old_chain[idx].begin;
      while (tmp) {
        add(tmp->key);
        tmp = tmp->next;
      }
    }
    delete[] old_chain;
  }

public:
  ADS_set(): chain{new HashTable[N]}, chain_count{N}, current_size{0} {}
  ADS_set(std::initializer_list<key_type> ilist): ADS_set{} {insert(ilist); }
  template<typename InputIt> ADS_set(InputIt first, InputIt last): ADS_set{} {insert(first,last); }
  ADS_set(const ADS_set &other) : ADS_set() {
     for (const auto& key : other) {
      add(key);
    }
    rehash(current_size);
  }

  ~ADS_set() { delete [] chain; };

  ADS_set &operator=(const ADS_set &other) {
    if (this == &other)
      {return *this; }

    ADS_set tmp{other};
    swap(tmp);
    return *this;
  }

  ADS_set &operator=(std::initializer_list<key_type> ilist) {
    ADS_set tmp{ilist};
    swap(tmp);
    return *this;
  }

  size_type size() const { return current_size; }
  bool empty() const { return current_size == 0; }

  void insert(std::initializer_list<key_type> ilist) {
    for (const auto& key : ilist) {
      if (!locate(key)) {
        add(key);
        if ((float)(current_size/chain_count) > max_lf) {
          rehash(chain_count * 2 + 1);
        }
      }
    }
  }         

  std::pair<iterator,bool> insert(const key_type &key) {
    Element *position {locate(key)};
    if (position)
      return {iterator{position, chain, h(key), chain_count}, false};
    add(key);
    if (current_size > chain_count * max_lf)
      rehash(chain_count * 2 + 1);
    return {iterator{locate(key), chain, h(key), chain_count}, true};
  }
  
  template<typename InputIt> void insert(InputIt first, InputIt last) {
    for (auto it = first; it != last; ++it) {
      if (!locate(*it)) {
        add(*it);
        if ((float)(current_size/chain_count) > max_lf) {
          rehash(chain_count * 2 + 1);
        }
      }
    }
  }

  void clear() {
    ADS_set tmp;
    swap(tmp);
  }

  size_type erase(const key_type &key) {
    size_type idx{h(key)};
    if(!chain[idx].length) {
        return 0;
    }
      else {
        Element* deletion {chain[idx].begin};
        if (key_equal{}(deletion->key, key)) {
          chain[idx].begin = deletion->next;
          deletion->next = nullptr;
          delete deletion;
          --chain[idx].length;
          --current_size;
          return 1;
        }
        while (deletion && !key_equal{}(deletion->key,key))
          deletion = deletion->next;
        if (!deletion) {
          return 0;
        }
        Element* tmp {chain[idx].begin};
        while (tmp->next != deletion)
          tmp = tmp->next;
        tmp->next = deletion->next;
        deletion->next = nullptr;
        delete deletion;
        tmp = nullptr;
        delete tmp;
        --chain[idx].length;
        --current_size;
        return 1;
      }
    }

  size_type count(const key_type& key) const { return locate(key) != nullptr; } 
  iterator find(const key_type &key) const {
    if (Element* tmp {locate(key)})
      return iterator{tmp, chain, h(key), chain_count};
    return end();
  }

  void swap(ADS_set &other) {
    std::swap(chain, other.chain);
    std::swap(current_size, other.current_size);
    std::swap(chain_count, other.chain_count);
  }

  const_iterator begin() const {
    if (!current_size)
      return end();
    return const_iterator(chain[this->locate_first()].begin, chain, locate_first(), chain_count);
  }

  const_iterator end() const {return const_iterator(); }

  size_type locate_first() const {
    for (size_type i{0}; i < chain_count; ++i) {
      if (chain[i].begin) { return i; }
    }
    return 0;
  }

  void dump(std::ostream& o = std::cerr) const {
    for (size_type i {0}; i < chain_count; ++i) {
      o << "chain[" << i << "]-> ";
      if (!chain[i].length) {
          o << chain[i].begin << '\n';
      }
       else {
          Element *tmp {chain[i].begin};
          while (tmp) {
            o << tmp->key;
            if (tmp->next)
              o << " -> ";
            tmp = tmp->next;
          }
          o << '\n';
        }
    }
  }
  
  friend bool operator==(const ADS_set &lhs, const ADS_set &rhs) {
    if (lhs.current_size != rhs.current_size)
      return false;
    for (const auto &key : rhs) {
      if (!lhs.locate(key)) return false;
    }
    return true;
  }

  friend bool operator!=(const ADS_set &lhs, const ADS_set &rhs) { return !(lhs == rhs); }
};


template <typename Key, size_t N>
class ADS_set<Key,N>::Iterator {
private:
  Element *e;
  HashTable *chain;
  size_type idx;
  size_type chain_count;
  void next() {
  while (idx < chain_count && chain[idx].begin == nullptr)
    ++idx;
  }
public:
  using value_type = Key;
  using difference_type = std::ptrdiff_t;
  using reference = const value_type &;
  using pointer = const value_type *;
  using iterator_category = std::forward_iterator_tag;

  explicit Iterator(Element *e = nullptr, HashTable* chain = nullptr, size_type idx = 0, size_type chain_count = N) : e{e}, chain{chain}, idx{idx}, chain_count{chain_count} {}
  reference operator*() const { return e->key; }
  pointer operator->() const { return &e->key; }

  Iterator &operator++() {
    if (e->next && e) {
      e = e->next;
    } 
      else {
      ++idx;
      next();
        if (idx == chain_count) {
          e = nullptr;
          return *this;
        }
        e = chain[idx].begin;
      }
    return *this;
  }

  Iterator operator++(int) { auto rc {*this}; ++*this; return rc;}
  friend bool operator==(const Iterator &lhs, const Iterator &rhs) { return lhs.e == rhs.e; }
  friend bool operator!=(const Iterator &lhs, const Iterator &rhs) { return !(lhs.e == rhs.e); }
};

template <typename Key, size_t N>
void swap(ADS_set<Key,N> &lhs, ADS_set<Key,N> &rhs) { lhs.swap(rhs); }


#endif // ADS_SET_H