import kivy
from kivy.app import App
from kivy.uix.switch import Switch
from kivy.uix.gridlayout import GridLayout
from kivy.uix.label import Label
from kivy.clock import Clock
from functools import partial
import time
import requests

class SwitchContainer(GridLayout): #create a class that uses the GridLayout module
    def __init__(self, **kwargs):
        super(SwitchContainer, self).__init__(**kwargs)

        self.inside = GridLayout()
        self.inside.cols = 4
        
        self.cols = 1

        self.inside.add_widget(Label(text="Iris Scanner: "))   #create a label for SW1
        self.sw1 = Switch(active=False) #create a SwitchCompat for SW1(default to OFF)
        self.inside.add_widget(self.sw1)   #add the created SwitchCompat to the screen
        self.sw1.disabled = True    #make SW1unclickable on the app

        self.inside.add_widget(Label(text="Proximity Fab: "))   #create a label for SW2
        self.sw2 = Switch(active=False) #create a SwitchCompat for SW2(default to OFF)
        self.inside.add_widget(self.sw2)   #add the created SwitchCompat to the screen
        self.sw2.disabled = True    #make SW2unclickable on the app

        self.inside.add_widget(Label(text="Door: "))#create a label for LED1
        self.led1 = Switch(active=False)#create a SwitchCompat for LED1(default to OFF)
        self.inside.add_widget(self.led1) #add the created SwitchCompat to the screen
        

        self.inside.add_widget(Label(text="Alarm: "))#create a label for LED2
        self.led2 = Switch(active=False)#create a SwitchCompat for LED2(default to OFF)
        self.inside.add_widget(self.led2) #add the created SwitchCompat to the screen

        self.add_widget(self.inside)
        

        self.add_widget(Label(text="Acknowldege Alarm:"))#create a label for LED2
        self.ACK = Switch(active=False)#create a SwitchCompat for LED2(default to OFF)
        self.add_widget(self.ACK) #add the created SwitchCompat to the screen

        
     

        #schedule the JSONrequest function to trigger every 5 seconds to read/write databases
        event = Clock.schedule_interval(partial(self.JSONrequest), 3)

    def JSONrequest(self, *largs):
        if (self.sw1.active == True):   #Get the sw1 active status and convert it to an integer
            SW1 = 1
        else:
            SW1 = 0
        
        if (self.sw2.active == True):   #Get the sw2 active status and convert it to an integer
            SW2 = 1
        else:
            SW2 = 0
        
        if (self.led1.active == True):  #Get the led1 active status and convert it to an integer
            LED1 = 1
        else:
            LED1 = 0
        
        if (self.led2.active == True):  #Get the led2 active status and convert it to an integer
            LED2 = 1
        else:
            LED2 = 0

        if (self.ACK.active == True):  #Get the led2 active status and convert it to an integer
            ACK = 1
            self.ACK.active = False
        else:
            ACK = 0

            
        #below are json request payload, the request itself, and the response

        data = {'username': 'ben','password':'benpass', 'SW1':SW1, 'SW2':SW2, 'LED1':LED1, 'LED2':LED2, 'ACK':ACK}    #json request payload
        res = requests.post("https://luistamborrell.000webhostapp.com/scripts/sync_app_data2.php", json=data)
        r = res.json()  #json respone

        if SW1 != int(r['SW1']): #check the received value of SW1 & change it on the App if there is a mismatch
            print("Changing SW1 status to the value in the database.")
            if self.sw1.active == True:
                self.sw1.active = False
            else:
                self.sw1.active = True
        else:
            return

        if SW2 != int(r['SW2']): #check the received value of SW2 & change it on the App if there is a mismatch
            print("Changing SW2 status to the value in the database.")
            if self.sw2.active == True:
                self.sw2.active = False
            else:
                self.sw2.active = True
        else:
            return

        

        
        
class SwitchExample(App):
    def build(self):
        return SwitchContainer()
    
if __name__=='__main__':
    SwitchExample().run()
