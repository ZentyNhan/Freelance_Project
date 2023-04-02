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
    #Get information from PHP:
    Email       = 'testfree300323@kikyushop.com'
    PassW       = 'Hoang123'

    #String Handling:
    
    #Instance:
    DRIVER = webdriver.Chrome(ChromeDriverManager().install())
    USER   = lib.Process(Email, PassW, 'dummy_1', 'dummy_2')

    #Method:
    Debug_1 = USER.accessSpotify(DRIVER)
    if Debug_1 == "passed":
        Debug_2 =  USER.switchNation(DRIVER)
        if Debug_2 in 'passed':
            Status = 'success'
            DRIVER.close()
            ret_dict = {
                'Status'     : Status,
                'Username'   : Email,
                'Time'       : datetime.datetime.now().strftime(USER.dt_format)
            }
        else:
            Status = 'failed'
            DRIVER.close()
            ret_dict = {
                'Status'     : Status,
                'Debug_1'    : Debug_1,
                'Debug_2'    : Debug_2,
                'Time'       : datetime.datetime.now().strftime(USER.dt_format)
            }
    else:
        Status = 'failed'
        DRIVER.close()
        ret_dict = {
            'Status'     : Status,
            'Debug_1'    : Debug_1,
            'Debug_2'    : 'null',
            'Time'       : datetime.datetime.now().strftime(USER.dt_format)
        }

    #Return:
    print(json.dumps(ret_dict))
