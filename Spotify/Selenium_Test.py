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

class delay():
    MINI_DELAY    = 0.5 #second
    SOFT_DELAY    = 1   #second
    DELAY         = 3   #second
    HARD_DELAY    = 5   #second
    MASSIVE_DELAY = 10  #second
    SUPER_DELAY   = 30  #second
    WORLD_DELAY   = 60  #second

class Process(delay):
    #Attributes:
    whoer_url    = f'https://whoer.net/fr'
    Spotify_url  = f'https://accounts.spotify.com/vi-VN/login?continue=https%3A%2F%2Fopen.spotify.com%2F'
    Profile_url  = f'https://www.spotify.com/tr/account/profile/'
    Element_dict = {
        'Nation_Sel'              : '''//body/div[@id='__next']/div[1]/div[1]/div[2]/div[2]/div[2]/div[1]/article[1]/section[1]/form[1]/div[1]/button[1]''',
        'join_invite'             : '''//header/a[1]/span[1]''',
        'join_address'            : '''//input[@id='address']''',
        'join_expired'            : '''//html[1]/body[1]/div[1]/main[1]/div[1]/section[1]/h1[1]''',
        'join_submit'             : '''//body/div[@id='__next']/form[1]/main[1]/div[1]/div[1]/fieldset[1]/div[1]/button[1]''',
        'continue_active_account' : '''/html[1]/body[1]/div[1]/main[1]/div[1]/div[1]/a[1]/span[1]''',
        'join_address_confirm'    : '''/html[1]/body[1]/div[1]/div[1]/div[1]/footer[1]/button[2]/span[1]/span[1]''',
        'join_sucess_status'      : '''/html[1]/body[1]/div[1]/main[1]/div[1]/section[1]/div[1]/h1[1]'''
    }
    Expired_list = ['Liên kết đó đã hết hạn', 'Bu bağlantının süresi doldu.']
    #Constructor:
    def __init__(self, user_, password_, familyURL_, address_):
        self.user      = user_
        self.password  = password_
        self.familyURL = familyURL_
        self.address   = address_
    def accessSpotify(self, driver):
        try:
            driver.get(self.Spotify_url)
            driver.maximize_window()
            sleep(self.DELAY)
            driver.find_element(By.ID ,'login-username').send_keys(self.user)
            driver.find_element(By.ID ,'login-password').send_keys(self.password)
            driver.find_element(By.ID ,'login-button').click()
            sleep(self.SOFT_DELAY)
            #Return:
            return 'passed'
        except Exception as e:
            return f'Failure: {e}'
    
    def switchNation(self, driver):
        try:
            sleep(self.DELAY)
            driver.get(self.Profile_url)
            sleep(self.DELAY)
            select = Select(driver.find_element(By.ID, 'country'))
            select.select_by_value('TR')
            driver.find_element(By.XPATH, self.Element_dict['Nation_Sel'] ).click()
            #Return:
            return 'passed'
        except Exception as e:
            return f'Failure: {e}'
    def joinPremium(self, driver):
        try:
            driver.get(self.familyURL) 
            sleep(self.DELAY)
            if driver.find_element(By.XPATH , self.Element_dict['join_expired']).text not in self.Expired_list:
                sleep(self.DELAY)
                driver.find_element(By.XPATH, self.Element_dict['join_invite'] ).click()
                sleep(self.DELAY)
                driver.find_element(By.XPATH, self.Element_dict['continue_active_account'] ).click()
                sleep(self.DELAY)
                driver.find_element(By.XPATH, self.Element_dict['join_address'] ).send_keys(self.address)
                sleep(self.DELAY)
                driver.find_element(By.XPATH, self.Element_dict['join_submit'] ).click()
                sleep(self.DELAY)
                driver.find_element(By.XPATH, self.Element_dict['join_address_confirm'] ).click()
                sleep(self.SOFT_DELAY)
                #Return:
                return 'Success'
            else:
                #Return:
                return 'Join Link expired'
        except Exception as e:
            return f'Failure: {e}'
    @classmethod
    def checkCurrentIP(cls, driver):
        driver.get(cls.whoer_url)

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
    sleep(delay.DELAY)
    DRIVER.find_element(By.XPATH, '//body/div[1]/div[3]/form[1]/div[1]/div[1]/div[1]/div[1]/div[2]/input[1]').send_keys('Python addict')
    sleep(delay.HARD_DELAY)
    DRIVER.close()
    ret_dict = {
        'Status'     : 'Status',
        'Username'   : Email,
        'Premium_ID' : Premium_ID,
        'Time'       : datetime.datetime.now().strftime(dt_format)
    }
    #Return:
    print(str(ret_dict))
