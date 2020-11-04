#!/usr/bin/python
import json
import requests  #import JSONRequests library
import time #import time library for sleep function

import datetime #import datetime library for timestamp
import RPi.GPIO as GPIO #import GPIO library
GPIO.setmode(GPIO.BCM)  #set the pins according to BCM scheme
GPIO.setup(4,GPIO.OUT)  #configure BCM Pin #4 as OUTPUT
GPIO.setup(22,GPIO.OUT)
GPIO.setup(17,GPIO.IN)  #configure BCM Pin #17 as INPUT
GPIO.setup(27,GPIO.IN)
i=0; n=20; delay=5;  #limit number of tries to 5 (initially set it to 1 for debugging)
while i<n:
    LED1=GPIO.input(4)  #read what BCM Pin #4 is set to (LED1)
    LED2=GPIO.input(22)
    SW1=GPIO.input(17)  #read the status of BCM Pin #17 (SW1)
    SW2=GPIO.input(27)
    TS = datetime.datetime.now()    #get the time stamp
    data = {'username': 'ben', 'password': 'benpass', 'SW1': SW1,'SW2': SW2, 'LED1': LED1, 'LED2': LED2, 'TS': str(TS) }

    res = requests.post("https://luistamborrell.000webhostapp.com/scripts/sync_rpi_data2.php", json=data) #in case of errors (especially, syntax) , you may want to print res.text and comment out the statements below
    r= res.json()
    print res.text
    
    
    print "==============Server Response at " + str(TS) + "=============="
    if r['success']==1:
        print "+++++Server request successful: "
        
        if LED1 != int(r['LED1']):
            print "Changing LED1 status as requested by the server"
            print str(r['LED1'])+" database and the LED1 is " + str(LED1)

            if int(r['LED1'])==1:
                print "Changing LED1 to HIGH"
                GPIO.output(4,1)
            else:
                print "Not changing the value of LED1"
                GPIO.output(4,0)

        if LED2 != int(r['LED2']):
            print "Changing LED2 status as requested by the server"
            print str(r['LED2'])+" database and the LED2 is " + str(LED2)

            if int(r['LED2'])==1:
                print "Changing LED2 to HIGH"
                GPIO.output(22,1)
            else:
                print "Not changing the value of LED2"
                GPIO.output(22,0)

        print "Time Stamp is " + str(TS)
        print "The status of Iris is " + str(r['SW1'])
        print "The status of Proximity Fab is " + str(r['SW2'])
        print "The status of Door is " + str(r['LED1'])
        print "The status of Alarm is " + str(r['LED2'])
    else:
        print ">>>>> Server request failed - Error #" + str(r['error'])
    time.sleep(delay)   #wait for delay seconds before sending another request
    i+=1

GPIO.cleanup()
