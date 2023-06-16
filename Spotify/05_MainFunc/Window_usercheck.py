########## SECTION: Library ##########
import sys
import os
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
        Email       = 'triet@cloud-air.com'
        PassW       = 'Triet1223'

        # Email       = str(sys.argv[1])
        # PassW       = str(sys.argv[2])

        #Instances:
        # op = webdriver.ChromeOptions()
        chrome_options = Options()
        chrome_options.add_argument("--headless=new")
        # op.add_argument('headless')
        DRIVER         = webdriver.Chrome(ChromeDriverManager().install(), options=chrome_options)
        LOGGING        = lib.logging(os.getcwd())
        USER           = lib.Process(Email, PassW, 'dummy_1', 'dummy_2', 'dummy_3', LOGGING)
        code           = '400'
        failure        = ['Failure', 'Timeout']
        failureMessage = 'none'

        #Method:
        # Method:
        Debug_1 = USER.accessSpotify(DRIVER)
        if Debug_1 == "Valid":
            code  = '200'
            message  = 'Tài khoản hợp lệ'
        else:
            message  = 'Tài khoản hoặc mật khẩu không hợp lệ'
        DRIVER.close()
            
        if Debug_1 == 'Invalid':
            ret_dict = {
                'status'     : code,
                'failure'    : failureMessage,
            }
        elif Debug_1[:7] not in failure:
            ret_dict = {
                'status'     : code,
                'username'   : Email,
            }
        elif Debug_1[:7] in failure[1]:
            ret_dict = {
                'status'     : '408',
                'failure'    : failure[1],
            } 
        else:
            ret_dict = {
                'status'     : code,
                'failure'    : failureMessage,
            }

        #Return:
        print(json.dumps(ret_dict))
    
    # Argument shortage: 
    except IndexError as error:
        print('Argument shortage')
    #Timeout:
    except TimeoutException as error:
        print('Timeout')
    #Others:
    except:
        print('Thất bại, không thể thực hiện được')




























