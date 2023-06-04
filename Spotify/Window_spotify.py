11########## SECTION: Library ##########
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
        Email       = 'nhan@cloud-air.com'
        PassW       = 'Nhan123456'
        familyURL   = 'https://www.spotify.com/vn-vi/family/join/invite/x69cx223A8cbcbY/'
        Address     = 'Binbirdirek,__Peykhane__Cd.__10/A,__34122 Fatih/İstanbul,__Türkiye' #Chuyển __ thành khoảng trắng
        Nation      = 'VN' #India test

        # Email       = str(sys.argv[1])
        # PassW       = str(sys.argv[2])
        # familyURL   = str(sys.argv[3])
        # Address     = str(sys.argv[4])
        # Nation      = str(sys.argv[5]) 
        
        #String Handling:
        dt_format  = "%d-%m-%Y_%H:%M:%S"
        ls         = familyURL.split('/')
        Ind        = ls.index('invite') + 1
        Premium_ID = ls[Ind]

        #Instances:
        op = webdriver.ChromeOptions()
        # op.add_argument('headless')
        DRIVER         = webdriver.Chrome(ChromeDriverManager().install(), options=op)
        LOGGING        = lib.logging(os.getcwd())
        USER           = lib.Process(Email, PassW, familyURL, Address, Nation, LOGGING)
        code           = '400'
        failure        = ['Failure', 'Timeout']
        failureMessage = 'none'
        Debug_1        = 'none'
        Debug_2        = 'none'
        Status         = 'none'

        #Method:
        Debug_1 = USER.accessSpotify(DRIVER)
        if Debug_1 in 'Valid':
            Debug_2 = USER.switchNation(DRIVER)
            if Debug_2 in 'Success':
                Status  = USER.joinPremium(DRIVER)
                if Status in 'Success':
                    code     = '200'
                elif Status in 'Join Link expired':
                    code     = '403'
                else: 
                    code     = '400'
                    failureMessage  = Status
            elif Debug_2 in 'Join Link expired':
                code     = '403'
            else:
                code     = '402'
                failureMessage  = Debug_2
        elif Debug_1 in 'Invalid':
            code     = '401'
            failureMessage = 'Invalid account'
        else:
            code     = '401'
            failureMessage  = Debug_1
        DRIVER.close()
        
        if Debug_1 == 'Invalid':
            ret_dict = {
                'status'     : code,
                'failure'    : failureMessage,
            }
        elif Debug_1[:7] not in failure and \
            Debug_2[:7] not in failure and \
            Status[:7] not in failure:
            ret_dict = {
                'status'     : code,
                'username'   : Email,
            }
        elif Debug_1[:7] in failure[1] or \
            Debug_2[:7] in failure[1] or \
            Status[:7] in failure[1]:
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
    # #Others:
    # except:
    #     print('Thất bại, không thể thực hiện được')




























