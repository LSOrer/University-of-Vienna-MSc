#ifndef ADS_SET_H
#define ADS_SET_H

#include <functional>
#include <algorithm>
#include <iostream>
#include <stdexcept>

template <typename Key, size_t N = 7>
class ADS_set {
public:
  using value_type = Key;
  using key_type = Key;
  using reference = value_type &;
  using const_reference = const value_type &;
  using size_type = size_t;
  using difference_type = std::ptrdiff_t;
  using key_equal = std::equal_to<key_type>;                       // Hashing
  using hasher = std::hash<key_type>;                              // Hashing

private:
  struct Node {
    key_type key;
    Node* next = nullptr;
    
    ~Node() {delete next; };
  };

  struct HashTable {
    Node* head = nullptr;
    size_type length = 0;

    ~HashTable() {delete head; }
  };

  HashTable* table = nullptr;
  size_type row_count = 0;
  size_type current_size = 0;
  float loadfactor = 0.7;

  void add(const key_type &key);
  Node* locate(const key_type &key) const;
  size_type hashFunction(const key_type &key) const;
  void rehash(size_type n);

public:
  ADS_set(): table{new HashTable[N]}, row_count{N}, current_size{0} {}                                                           // PH1
  ADS_set(std::initializer_list<key_type> ilist): ADS_set{} {insert(ilist); }                      // PH1
  template<typename InputIt> ADS_set(InputIt first, InputIt last): ADS_set{} {insert(first, last); }    // PH1

  ~ADS_set() { delete[] table; };

  size_type size() const {return current_size; }                                              // PH1
  bool empty() const {return current_size == 0; }                                                 // PH1

  void insert(std::initializer_list<key_type> ilist){                // PH1
    for(const auto &key : ilist){
      if(!locate(key)){
        add(key);
        if((float)current_size/row_count > loadfactor){
          rehash(row_count * 2);
        }
      }
    }
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


  size_type count(const key_type &key) const {return locate(key) != nullptr; }                          // PH1

  void dump(std::ostream &o = std::cerr) const {
    o << "row_count = " << row_count << ", current_size = " << current_size << "\n";
      for(size_type i = 0; i < row_count; i++){
        o << "Row[" << i << "]: ";
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
  HashTable* old_table = table;
  size_type old_row_count = row_count;
  table = nullptr;
  delete[] table;
  table = new HashTable[new_row_count];
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


#if 0
template <typename Key, size_t N>
class ADS_set<Key,N>::/* iterator type */ {
public:
  using value_type = Key;
  using difference_type = std::ptrdiff_t;
  using reference = const value_type &;
  using pointer = const value_type *;
  using iterator_category = std::forward_iterator_tag;

  explicit /* iterator type */(/* implementation-dependent */);
  reference operator*() const;
  pointer operator->() const;
  /* iterator type */ &operator++();
  /* iterator type */ operator++(int);
  friend bool operator==(const /* iterator type */ &lhs, const /* iterator type */ &rhs);
  friend bool operator!=(const /* iterator type */ &lhs, const /* iterator type */ &rhs);
};

template <typename Key, size_t N>
void swap(ADS_set<Key,N> &lhs, ADS_set<Key,N> &rhs) { lhs.swap(rhs); }
#endif
#endif // ADS_SET_H
