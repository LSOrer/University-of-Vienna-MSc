#include "ADS_set_final23.h"

int main()
{
  ADS_set<int> s;
  s.insert(1);
  s.insert(2);
  s.insert(3);
  s.insert(4);
  s.insert(5);
  s.insert(6);
  s.insert(7);


  auto iterator = s.y();
  while(iterator != s.end()){
    std::cout << *(iterator++) << "\t";
  }
  
  std::cout << std::endl << "*********** NEW ************" << std::endl;
  ADS_set<int> t;
  t.insert(1);
  t.insert(2);
  t.insert(3);
  t.insert(4);

  auto iterator_t = t.y();
  std::cout << std::endl;
  while(iterator_t != t.end()){
    std::cout << *(iterator_t++) << "\t";
  }

  std::cout << std::endl << "*********** NEW ************" << std::endl;
  ADS_set<int> t1;
  t1.insert(1);
  t1.insert(2);
  t1.insert(3);

  auto iterator_t1 = t1.y();
  std::cout << std::endl;
  while(iterator_t1 != t1.end()){
    std::cout << *(iterator_t1++) << "\t";
  }

  std::cout << std::endl << "*********** NEW ************" << std::endl;
  ADS_set<int> t4;
  t4.insert(1);
  t4.insert(2);

  auto iterator_t4 = t4.y();
  std::cout << std::endl;
  while(iterator_t4 != t4.end()){
    std::cout << *(iterator_t4++) << "\t";
  }

  std::cout << std::endl << "*********** NEW ************" << std::endl;
  ADS_set<int> t5;
  t5.insert(1);

  auto iterator_t5 = t5.y();
  std::cout << std::endl;
  while(iterator_t5 != t5.end()){
    std::cout << *(iterator_t5++) << "\t";
  }

}