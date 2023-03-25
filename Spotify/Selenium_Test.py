########## SECTION: Library ##########
import sys
from pickle import FALSE, TRUE
from subprocess import check_output
# from webdriver_manager.chrome import ChromeDriverManager
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
import requests
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
    Email       = 'free280223@kikyushop.com'
    PassW       = 'Hoang123'
    familyURL   = 'https://www.spotify.com/tr-tr/family/join/invite/CzX87ZyAX178xbc/'
    Address     = 'Binbirdirek, Peykhane Cd. 10/A, 34122 Fatih/İstanbul, Türkiye'

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
    options.add_argument("--headless")
    options.add_argument('--disable-gpu')
    options.add_argument("--disable-extensions")
    options.add_argument('--disable-dev-shm-usage')
    options.add_argument("--remote-debugging-port=9222")
    DRIVER = webdriver.Chrome(executable_path=driver_location,options=options)
    
    DRIVER.get('https://www.google.com.vn/')
    DRIVER.maximize_window()
    sleep(lib.Process.DELAY)
    DRIVER.find_element(By.XPATH, '//body/div[1]/div[3]/form[1]/div[1]/div[1]/div[1]/div[1]/div[2]/input[1]').send_keys('Python addict')
    sleep(lib.Process.HARD_DELAY)
    DRIVER.close()
    ret_dict = {
        'Status'     : 'Status',
        'Username'   : Email,
        'Premium_ID' : Premium_ID,
        'Time'       : datetime.datetime.now().strftime(dt_format)
    }
    #Return:
    print(str(ret_dict))
