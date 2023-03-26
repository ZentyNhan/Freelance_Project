########## SECTION: Library ##########
import sys
from pickle import FALSE, TRUE
from subprocess import check_output
from webdriver_manager.chrome import ChromeDriverManager #Window flatform only
from pyvirtualdisplay import Display  #Window flatform only
from selenium import webdriver
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.select import Select
from selenium.common.exceptions import TimeoutException
from selenium.common.exceptions import NoSuchElementException,ElementNotInteractableException,ElementClickInterceptedException
from selenium.webdriver.support import expected_conditions as EC
from time import sleep
from datetime import datetime
from datetime import date
import time
import datetime
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import json
#Self lib
import lib

#Main:
if __name__ == "__main__": 
    
    ########## ANCHOR: DO NOT CHANGE ##########
    # Get information from PHP: 
    Email       = 'freetest173@kikyushop.com'
    # Email       = 'freetest17323@kikyushop.com'
    PassW       = 'Hoang123'
    familyURL   = 'https://www.spotify.com/tr-tr/family/join/invite/CzX87ZyAX178xbc/'
    Address     = 'Binbirdirek, Peykhane Cd. 10/A, 34122 Fatih/İstanbul, Türkiye'

    #String Handling:
    dt_format  = "%d-%m-%Y_%H:%M:%S"

    #Instances:
    DRIVER = webdriver.Chrome(ChromeDriverManager().install())
    USER   = lib.Process(Email, PassW, familyURL, Address)
    
    #Method:
    Debug_1 = USER.accessSpotify(DRIVER)
    if Debug_1 == 'passed':
        sleep(USER.DELAY)
        Debug_2 = USER.userCheck(DRIVER)
        if Debug_2 == 'Valid':
            Code   = '200' # OK
            Status = 'Success'
            DRIVER.close()
        else:
            Code   = '410' # Gone
            Status = 'Failed'
            DRIVER.close()
    else:
        Code   = '408' # Timeout
        Status = 'Failed'
        DRIVER.close()
       
    #Return:
    ret_dict = {
            'Code'     : Code,
            'Status'   : Status,
            'Time'     : datetime.datetime.now().strftime(dt_format)
    }
    print(str(ret_dict))
        

    

