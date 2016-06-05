#!/bin/bash
echo " "
echo "Initiating ........"


for (( c=1 ; c <= 10000 ; c++ ))
do
   date 
   echo "Execution Number : $c ... "
   curl "http://localhost/data-kolkata.php"
   sleep 1s
   echo "--------------------------------------------------------------------------------------------------------"
done
