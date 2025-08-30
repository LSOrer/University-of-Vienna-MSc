#include <iostream>

int main(){
    int counter = 5;
    for(int i=0; i < counter; i++){
        for(int j = 0; j < i; j++){
            std::cout << j << std::endl;
        }
    }  
}

