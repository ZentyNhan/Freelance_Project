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
import datetime
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import json
#Self lib
import lib

#Main:
if __name__ == "__main__": 
    
    ########## ANCHOR: DO NOT CHANGE ##########
    #Get information from PHP:
    Email       = 'testfree3003@kikyushop.com'
    PassW       = 'Hoang123'
    familyURL   = 'https://www.spotify.com/vn-vi/family/join/invite/2X06z34zc93zB11/'
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
    USER.HARD_DELAY
    Debug_2 = USER.switchNation(DRIVER)
    USER.HARD_DELAY
    if (Debug_1 in 'passed') and (Debug_2 in 'passed'):
        Status  = USER.joinPremium(DRIVER)
        DRIVER.close()
        ret_dict = {
            'Status'     : Status,
            'Username'   : Email,
            'Premium_ID' : Premium_ID,
            'Time'       : datetime.datetime.now().strftime(dt_format)
        }
    else:
        Status = 'failed'
        DRIVER.close()
        ret_dict = {
            'Status'     : Status,
            'Debug_1'    : Debug_1,
            'Debug_2'    : Debug_2,
            'Time'       : datetime.datetime.now().strftime(dt_format)
        }

    #Return:
    print(json.dumps(ret_dict))




























