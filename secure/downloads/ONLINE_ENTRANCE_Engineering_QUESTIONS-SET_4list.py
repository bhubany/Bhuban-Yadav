# #LIST
# # List is an ordered sqquence of items. It is one of the most used  datatypes in python and is very flexible. All the
# #Declaring a list is preety straight forward. Items separated by commas are enclosed within brackets[].
# # Declaration=list1=[1,2.5,3+5j,True,"KATHMANDU"]
# from array import array
# list1=[1,2.5,3+5j,True,"Kathmandu",array('i',[6,7,8,9,10]),[1,2,3,4]]   #We can also declare arrays and lists inside lists
# print(type(list1))
# print(len(list1))
# print(list1)
# #If length is l then we can do indexing upto l-1
# print(list1[1])     #Printing values on arrays from arrays
# print(list1[:])
# print(list1[1:])
# print(list1[2:5])
# print(list1[:2])
# MAX=len(list1)
#
#                     #LOOPING
# #WHILE LOOP
# i=0
# while i<MAX:
#     print(list1[i])
#     print(type(list1[i]))
#     i=i+1
#
# #FOR LOOP
# for item in list1:      #Acessing individuals items from list
#     print(item,"|",type(item))      #Printing all items with their data types
#     if type(item)==int or type(item)==float or type(item)==complex or type(item)==bool:
#         print(item)
#     else:
#         for tmp in item:    #Acessing elements of individuals items with containing collections
#             print(tmp)

                #LIST DECLARATION AND INITIALIZATION
list0=list(())      #Declaring blank list
print(type(list0))
print(len(list0))

list1=[]        #2nd method to declare blank list
print(type(list1))
print(len(list1))
print(isinstance(list1, list))

#3rd method to declare lists
list2=([1,3,5,7])
print(type(list2))
print(len(list2))

list3=([1,2.5,True,3+5j,"Kathmandu"])              #ALready declared this method on above initializing hybrid types of values
print(type(list3))
print(len(list3))

from array import array
my_array=array('i',[1,2])
print(type(my_array))
print(len(my_array))
list5=list(my_array)
print(type(list5))
print(len(list5))
print(list5)

# Nested list
list6=["Hey",123,["Dog","Cat","Bird"]]
print(type(list6))
print(len(list6))

list7=list(("apple","banana","cherry"))
print(type(list7))
leng=len(list7)
print(leng)
print(list7)
print(list7[1])
print("Using while loops and positive indexing")
i=0
while i<leng:
    print(list7[i])
    i=i+1
j=-1
print("Using while loops and negative indexing")
while j>=(-leng):
    print(list7[j])
    j=j-1

# ACCESSING LIST
print("Accessing list")
fruits=['orange','apple','banana','pear','kiwi','strawberry']
print(fruits[:])
print(fruits[:3])
print(fruits[1:3])
print(fruits[-5:-2])
print(fruits[0:len(fruits):3])
print(fruits[len(fruits):0:-2])
print(fruits[::-1])
fruits_1=fruits[:]      #Using slicing we get different address locations on memory
fruits_2=fruits         #using direct copying we get same address locations on memory i.e copy by reference if we change value at one place then values are changes at all locations of same address
print(fruits)
print(fruits_1)
print(fruits_2)
print(id(fruits))
print(id(fruits_1))
print(id(fruits_2))
#Exploring class of lists
print(dir(fruits))      #Printing all directory present on lists
print(help(list))       #Self is the current class or this class.
#h\w try all the functions present on help functions of list