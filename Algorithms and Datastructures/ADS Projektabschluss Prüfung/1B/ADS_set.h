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
  using key_compare = std::less<key_type>;                         // B+-Tree
  using key_equal = std::equal_to<key_type>;                       // Hashing
  using hasher = std::hash<key_type>;                              // Hashing

private:
struct Node {
  key_type key;
  Node* next = nullptr;

  ~Node() {delete next; };
};

struct Hashtable {
  Node* head = nullptr;
  size_type length = 0;

  ~Hashtable() {delete head; };
};

Hashtable* table = nullptr;
size_type row_count = 0;
size_type current_size = 0;
float loadfactor = 0.8;

void add(const key_type &key);
Node* locate(const key_type &key) const;
size_type hashFunction(const key_type &key) const;
void rehash(size_type n);


public:
  ADS_set(): table{new Hashtable[N]}, row_count{N}, current_size{0} {}                                                           // PH1
  ADS_set(std::initializer_list<key_type> ilist): ADS_set{} {insert(ilist); }                     // PH1
  template<typename InputIt> ADS_set(InputIt first, InputIt last): ADS_set{} {insert(first, last); }     // PH1
  ADS_set(const ADS_set &other) : ADS_set() {
    for(const auto& key : other) {
      add(key);
    }
    rehash(current_size);
  }

  ~ADS_set() {delete[] table; };

  ADS_set &operator=(const ADS_set &other) {
    if(this == &other) {
      return *this;
    }
    ADS_set temp{other};
    swap(temp);
    return *this;
  }

  ADS_set &operator=(std::initializer_list<key_type> ilist) {
    ADS_set temp{ilist};
    swap(temp);
    return *this;
  }

  size_type size() const {return current_size; }                                              // PH1
  bool empty() const {return current_size == 0; }                                                  // PH1

  void insert(std::initializer_list<key_type> ilist){
    for(const auto &key : ilist){
      if(!locate(key)){
        add(key);
        if((float)current_size/row_count > loadfactor){
          rehash(row_count * 2);
        }
      }
    }
  }                 // PH1

  std::pair<iterator,bool> insert(const key_type &key) {
    Node* position = locate(key);
    if(position)
      return {iterator{position, table, hashFunction(key), row_count}, false};
    add(key);
    if((float)current_size/row_count > loadfactor)
      rehash(row_count * 2);
    return {iterator{locate(key), table, hashFunction(key), row_count}, true};
  }

  template<typename InputIt> void insert(InputIt first, InputIt last){
    for(auto it = first; it != last; it++){
      if(!locate(*it)){
        add(*it);
        if((float)current_size/row_count > loadfactor){
          rehash(row_count * 2);
        }
      }
    }
  } // PH1

  void clear() {
    ADS_set temp;
    swap(temp);
  }

  size_type erase(const key_type &key) {
    size_type index = hashFunction(key);
    if(!table[index].length) {
      return 0;
    } else {
      Node* deletion = table[index].head;
      if(key_equal{}(deletion->key, key)) {
        table[index].head = deletion->next;
        deletion->next = nullptr;
        delete deletion;
        --table[index].length;
        --current_size;
        return 1;
      }
      while(deletion && !key_equal{}(deletion->key, key))
        deletion = deletion->next;
      if(!deletion){
        return 0;
      }
      Node* temp = table[index].head;
      while(temp->next != deletion)
        temp = temp->next;
      temp->next = deletion->next;
      deletion->next = nullptr;
      delete deletion;
      temp = nullptr;
      delete temp;
      --table[index].length;
      --current_size;
      return 1; 
    }
  }

  size_type count(const key_type &key) const {return locate(key) != nullptr; }                          // PH1
  iterator find(const key_type &key) const {
    if(Node* temp {locate(key)})
      return iterator{temp, table, hashFunction(key), row_count};
    return end();
  }

  void swap(ADS_set &other) {
    std::swap(table, other.table);
    std::swap(current_size, other.current_size);
    std::swap(row_count, other.row_count);
  }

  const_iterator begin() const {
    if(!current_size)
      return end();
    return const_iterator(table[this->locate_first()].head, table, locate_first(), row_count);
  }

  const_iterator end() const { return const_iterator(); }

  size_type locate_first() const {
    for(size_type i=0; i < row_count; i++) {
      if(table[i].head) { return i; }
    }
    return 0;
  }

  const_iterator y() const {
    if(!current_size)
      return end();
    return const_iterator(table[this->locate_first()].head, table, locate_first(), row_count, true);
  }

  void dump(std::ostream &o = std::cerr) const {
    float current_load = (float)current_size/row_count;
    o << "row_count: " << row_count << ", current_size: " << current_size << ", loadfactor: " << current_load << "\n";
    for(size_type i = 0; i < row_count; i++){
      o << "Row(" << i << "): ";
      if(!table[i].length){
        o << table[i].head << "\n";
      } else {
        Node* temp = table[i].head;
        while(temp){
          o << temp->key;
          if(temp->next)
            o << " -> ";
          temp = temp->next;
        }
        o << "\n";
      }
    }
  }

  friend bool operator==(const ADS_set &lhs, const ADS_set &rhs) {
    if(lhs.current_size != rhs.current_size)
      return false;
    for(const auto &key : rhs) {
      if(!lhs.locate(key)) return false;
    }
    return true;
  }

  friend bool operator!=(const ADS_set &lhs, const ADS_set &rhs) { return !(lhs == rhs); }
};

template <typename Key, size_t N>
typename ADS_set<Key, N>::size_type ADS_set<Key, N>::hashFunction(const key_type &key) const {
  return hasher{}(key) % row_count;
}

template <typename Key, size_t N>
void ADS_set<Key, N>::add(const key_type &key) {
  Node* newNode = new Node();
  newNode->key = key;

  size_type index = hashFunction(key);

  newNode->next = table[index].head;
  table[index].head = newNode;
  
  ++table[index].length;
  ++current_size;
}

template <typename Key, size_t N>
typename ADS_set<Key, N>::Node* ADS_set<Key, N>::locate(const key_type &key) const {
  size_type index = hashFunction(key);
  if(!table[index].length){
    return nullptr;
  } else {
    Node* temp = table[index].head;
    while(temp){
      if(key_equal{}(temp->key, key)){
        return temp;
      }
      temp = temp->next;
    }
    return nullptr;
  }
}

template <typename Key, size_t N>
void ADS_set<Key, N>::rehash(size_type n) {
  size_type new_row_count = std::max(N, n);
  Hashtable* old_table = table;
  size_type old_row_count = row_count;
  table = nullptr;
  delete[] table;
  table = new Hashtable[new_row_count];
  row_count = new_row_count;
  current_size = 0;
  Node* temp = nullptr;

  for(size_type index = 0; index < old_row_count; index++){
    temp = old_table[index].head;
    while(temp){
      add(temp->key);
      temp = temp->next;
    }
  }
  delete[] old_table;
}




template <typename Key, size_t N>
class ADS_set<Key,N>::Iterator {
private:
  Node* e;
  Hashtable* table;
  size_type index;
  size_type row_count;
  bool special_mode;
  void skip(){
    while (index < row_count && table[index].head == nullptr)
      index++;
  }
public:
  using value_type = Key;
  using difference_type = std::ptrdiff_t;
  using reference = const value_type &;
  using pointer = const value_type *;
  using iterator_category = std::forward_iterator_tag;

  explicit Iterator(Node* e = nullptr, Hashtable* table = nullptr, size_type index = 0, size_type row_count = N, bool special_mode = false) : e{e}, table{table}, index{index}, row_count{row_count}, special_mode{special_mode}  {}
  reference operator*() const { return e->key; }
  pointer operator->() const { return &e->key; }
  Iterator &operator++(){
    if(special_mode == false){
      return getNext();
    } else {
      for(size_type i = 0; i < 3; i++){
        if (e->next && e) {
          e = e->next;
        } else {
          index++;
          skip();
          if(index >= row_count) {
            if(i > 0){
              return *this;
            } else {
              e = nullptr;
              return *this;
            }
          }
          e = table[index].head;
        }
      }
      return *this;
    }
  }

  Iterator &getNext(){
    if (e->next && e) {
      e = e->next;
    } else {
      index++;
      skip();
      if(index >= row_count) {
        e = nullptr;
        return *this;
      }
      e = table[index].head;
    }
    return *this;
  }

  Iterator operator++(int) { auto rc {*this}; ++*this; return rc; }
  friend bool operator==(const Iterator &lhs, const Iterator &rhs) { return lhs.e == rhs.e; }
  friend bool operator!=(const Iterator &lhs, const Iterator &rhs) { return !(lhs.e == rhs.e); }
};

template <typename Key, size_t N>
void swap(ADS_set<Key,N> &lhs, ADS_set<Key,N> &rhs) { lhs.swap(rhs); }

#endif // ADS_SET_H
