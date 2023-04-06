11########## SECTION: Library ##########
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

#Main:
if __name__ == "__main__": 
    try: 
        ########## ANCHOR: DO NOT CHANGE ##########
        # #Get information from PHP:
        Email       = 'testfree33@kikyushop.com'
        PassW       = 'Hoang123'
        familyURL   = 'https://www.spotify.com/vn-vi/family/join/invite/BZA98b8b3XaA4Ax/'
        Address     = 'Binbirdirek, Peykhane Cd. 10/A, 34122 Fatih/İstanbul, Türkiye'

        # Email       = str(sys.argv[1])
        # PassW       = str(sys.argv[2])
        # familyURL   = str(sys.argv[3])
        Address     = 'Binbirdirek, Peykhane Cd. 10/A, 34122 Fatih/İstanbul, Türkiye'

        #String Handling:
        dt_format  = "%d-%m-%Y_%H:%M:%S"
        ls         = familyURL.split('/')
        Ind        = ls.index('invite') + 1
        Premium_ID = ls[Ind]

        #Instances:
        DRIVER = webdriver.Chrome(ChromeDriverManager().install())
        USER   = lib.Process(Email, PassW, familyURL, Address)

        #Method:
        Debug_1 = USER.accessSpotify(DRIVER)
        if Debug_1 in 'Valid':
            Debug_2 = USER.switchNation(DRIVER)
            if Debug_2 in 'Success':
                Status  = USER.joinPremium(DRIVER)
                if Status in 'Success':
                    code     = '200'
                    message  = 'Join Spotify Family successfully'
                elif Status in 'Join Link expired':
                    code    = '400'
                    message = 'Join Link expired'
                else: 
                    code    = '400'
                    message = 'Joining Spotify Family failed'
                    failure  = Status
            elif Debug_2 in 'Join Link expired':
                code    = '400'
                message = 'Join Link expired'
            else:
                code    = '400'
                message = 'Country transfer failed'
                failure  = Debug_2
        elif Debug_1 in 'Invalid':
            code    = '400'
            message = 'login unsuccessful'
        else:
            code     = '400'
            message  = 'login unsuccessful'
            failure  = Debug_1
        DRIVER.close()
    
        if Debug_1[:7] not in 'Failure' or \
            Debug_2[:7] not in 'Failure' or \
            Status[:7] not in 'Failure':
            ret_dict = {
                'Status'     : code,
                'message'    : message,
                'username'   : Email,
            }
        else:
            ret_dict = {
                'Status'     : code,
                'message'    : message,
                'failure'    : failure,
            }

        #Return:
        print(json.dumps(ret_dict))
    
    # Argument shortage: 
    except IndexError as error:
        print('Argument shortage')




























