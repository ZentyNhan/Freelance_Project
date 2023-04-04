########## SECTION: Library ##########
import sys
from pickle import FALSE, TRUE
from subprocess import check_output
from webdriver_manager.chrome import ChromeDriverManager #Window flatform only
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
import pickle
import datetime
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import json
#Self lib
import lib

if __name__ == "__main__": 
    
    ########## ANCHOR: DO NOT CHANGE ##########
    try:
        #Get information from PHP:
        # Email       = str(sys.argv[1])
        # PassW       = str(sys.argv[2])
        # familyURL   = str(sys.argv[3])
        # Address     = str(sys.argv[4])
        Email       = 'free090323@kikyushop.com'
        PassW       = 'Hoang123'
        familyURL   = 'https://www.spotify.com/tr-tr/family/join/invite/CzX87ZyAX178xbc/'
        Address     = 'Binbirdirek, Peykhane Cd. 10/A, 34122 Fatih/İstanbul, Türkiye'

        #String Handling:
        ls         = familyURL.split('/')
        Ind        = ls.index('invite') + 1
        Premium_ID = ls[Ind]
        
        #Instance:
        DRIVER = webdriver.Chrome(ChromeDriverManager().install())
        USER   = lib.Process(Email, PassW, familyURL, Address)

        #Method:
        Debug = USER.accessSpotify(DRIVER)
        if Debug == "passed":
            Status  = USER.joinPremium(DRIVER)
            DRIVER.close()
            ret_dict = {
                'Status'     : Status,
                'Username'   : Email,
                'Premium_ID' : Premium_ID,
                'Time'       : datetime.datetime.now().strftime(USER.dt_format)
            }
        else:
            Status = 'failed'
            DRIVER.close()
            ret_dict = {
                'Status'     : Status,
                'Debug'      : Debug,
                'Time'       : datetime.datetime.now().strftime(USER.dt_format)
            }
        #Return:
        print(json.dumps(ret_dict))

    #Argument shortage: 
    except IndexError as error:
        print('Argument shortage')