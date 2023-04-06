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
import pickle
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
        # Get information from PHP: 
        # Email =  str(sys.argv[1])
        # PassW =  str(sys.argv[2])
        Email       = 'free090323@kikyushop.com'
        PassW       = 'Hoang123'

        #Instances:
        DRIVER = webdriver.Chrome(ChromeDriverManager().install())
        USER   = lib.Process(Email, PassW, 'dummy_1', 'dummy_2')
        Code     = "null"
        Username = "null"
        
        # Method:
        Debug_1 = USER.accessSpotify(DRIVER)
        if Debug_1 == "passed":
            sleep(USER.DELAY)
            Debug_2 = USER.userCheck(DRIVER)
            if Debug_2 == "Valid":
                Code     = "200" # OK
                DRIVER.close()
            else:
                Code   = "400" # Gone
                DRIVER.close()
        else:
            Code   = "401" # Timeout
            DRIVER.close()
        
        #Return:
        ret_dict = {
                "status"    : Code,
                "username"  : Email,
                "time"      : datetime.datetime.now().strftime(USER.dt_format)
        }
        print(json.dumps(ret_dict))

    # Argument shortage: 
    except IndexError as error:
        print('Argument shortage')

        

    

