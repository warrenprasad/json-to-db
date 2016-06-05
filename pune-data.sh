#!/bin/bash
echo " "
echo "Initiating ........"


for (( c=1 ; c <= 13149 ; c++ ))
do
   date 
   echo "Execution Number : $c ... "
   curl "http://localhost/data-pune.php"
   sleep 1s
   echo "--------------------------------------------------------------------------------------------------------"
done
