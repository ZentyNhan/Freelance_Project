########## SECTION: Library ##########
import sys
import os
from pickle import FALSE, TRUE
from subprocess import check_output
from webdriver_manager.chrome import ChromeDriverManager #Window flatform only
# from selenium import webdriver
from seleniumwire import webdriver
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.select import Select
from selenium.common.exceptions import TimeoutException
from selenium.webdriver.support import expected_conditions as EC
from time import sleep
from datetime import datetime
from datetime import date
import time
import pickle
import datetime
# from selenium import webdriver
# from selenium.webdriver.chrome.options import Options
import json
#Self lib
import lib

#Main:
if __name__ == "__main__": 
    try: 
        ########## ANCHOR: DO NOT CHANGE ##########
        # #Get information from PHP:
        Email       = 'nhan@cloud-air.com'
        PassW       = 'Nhan123'

        # Email       = str(sys.argv[1])
        # PassW       = str(sys.argv[2])

        #Instances:
        # op = webdriver.ChromeOptions()
        # op.add_argument('headless')
        
       
        
        #proxy:
        PROXY = [
                    {'protocol': 'https',  'IP'  : '45.149.131.243:64560', 'Proxy_User': 'EAzGMRSu', 'Proxy_PW'  : 'ZiNQDnXh'}, #HTTPs
                    {'protocol': 'socks5', 'IP'  : '45.149.131.243:64561', 'Proxy_User': 'EAzGMRSu', 'Proxy_PW'  : 'ZiNQDnXh'}, #SOCKS5
        ]

        options = {
            'proxy': {
                'http':  '{0}://{1}:{2}@{3}'.format(PROXY[1]['protocol'], PROXY[1]['Proxy_User'], PROXY[1]['Proxy_PW'], PROXY[1]['IP']),
                'https': '{0}://{1}:{2}@{3}'.format(PROXY[1]['protocol'], PROXY[1]['Proxy_User'], PROXY[1]['Proxy_PW'], PROXY[1]['IP']),
                'no_proxy': 'localhost,127.0.0.1'
            }
        }
        
        # chrome_options = Options()
        # chrome_options.add_argument('--proxy-server=%s' % PROXY[0]['IP'])
        # chrome_options.add_argument("ignore-certificate-errors")
        
        # chrome_options.add_argument("--headless=new")
        DRIVER         = webdriver.Chrome(ChromeDriverManager().install(), seleniumwire_options=options)
        LOGGING        = lib.logging(os.getcwd())
        USER           = lib.Process(Email, PassW, 'dummy_1', 'dummy_2', 'dummy_3', LOGGING)
        code           = '400'
        failure        = ['Failure', 'Timeout']
        failureMessage = 'none'
        
        
        USER.checkCurrentIP(DRIVER)  

    
    # Argument shortage: 
    except IndexError as error:
        print('Argument shortage')
    #Timeout:
    except TimeoutException as error:
        print('Timeout')
    #Others:
    # except:
    #     print('Thất bại, không thể thực hiện được')




























