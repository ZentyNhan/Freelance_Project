########## SECTION: Library ##########
import sys
from pickle import FALSE, TRUE
from subprocess import check_output
# from webdriver_manager.chrome import ChromeDriverManager
# from pyvirtualdisplay import Display
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
    try:
        #Get information from PHP:
        Email       = str(sys.argv[1])
        PassW       = str(sys.argv[2])
        familyURL   = str(sys.argv[3])
        Address     = str(sys.argv[4])
        #String Handling:
        dt_format  = "%d-%m-%Y_%H:%M:%S"
        ls         = familyURL.split('/')
        Ind        = ls.index('invite') + 1
        Premium_ID = ls[Ind]
        #Instances:
        driver_location = '/usr/bin/chromedriver'
        binary_location = '/usr/bin/google-chrome'
        options = webdriver.ChromeOptions()
        options.binary_location = binary_location
        options.add_argument('--no-sandbox')
        options.add_argument('--window-size=1420,1080')
        options.add_argument('--headless')
        options.add_argument('--disable-gpu')
        DRIVER = webdriver.Chrome(executable_path=driver_location,options=options)
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
        print(str(ret_dict))
    
    # Argument shortage: 
    except IndexError as error:
        print('Argument shortage')