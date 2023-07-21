import sys
import os
from pickle import FALSE, TRUE
from subprocess import check_output
# from webdriver_manager.chrome import ChromeDriverManager #Window flatform only
# from pyvirtualdisplay import Display #Window flatform only
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
from termcolor import colored 
import time
import random
import pickle
import string
import datetime
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import json

class delay():
    #Attributes:
    MINI_DELAY    = 0.5 #second
    SOFT_DELAY    = 1   #second
    FLEX_DELAY    = 1.5   #second
    SPONGY_DELAY  = 2   #second
    DELAY         = 3   #second
    HARD_DELAY    = 5   #second
    HUGH_DELAY    = 10  #second
    MASSIVE_DELAY = 20  #second
    SUPER_DELAY   = 30  #second
    WORLD_DELAY   = 60  #second
    
class proxy():
    #Attributes:
    info = {
        'Indian' : [
            {'protocol': 'https',  'IP'  : '89.185.86.189:63738', 'User': 'EAzGMRSu', 'PW'  : 'ZiNQDnXh', 'Nation' : 'IN'}, #HTTPs Indian
            {'protocol': 'socks5', 'IP'  : '89.185.86.189:63739', 'User': 'EAzGMRSu', 'PW'  : 'ZiNQDnXh', 'Nation' : 'IN'}, #SOCKS5 Indian
        ],
        
        'Turkey' : [
            {'protocol': 'https',  'IP'  : '45.149.131.243:64560', 'User': 'EAzGMRSu', 'PW'  : 'ZiNQDnXh', 'Nation' : 'TR'}, #HTTPs Turkey
            {'protocol': 'socks5', 'IP'  : '45.149.131.243:64561', 'User': 'EAzGMRSu', 'PW'  : 'ZiNQDnXh', 'Nation' : 'TR'}, #SOCKS5 Turkey
        ]
    }
    
class VerificationCode():
    #Attributes:
    vc_quantity     = 10
    vc_quantity_max = 50
    
    #Methods:
    def generateVC(size=8, chars=string.ascii_uppercase + string.digits):
        return 'SF' + ''.join(random.choice(chars) for _ in range(size)) #Spotify Famlily

class ResponseConfig():
    #Attributes:
    ResponseCode = {
        #Customer:
        '200' :	{'status':'Thành công'  ,'detail':{'admin':'Joined Spotify Family Successfully',                      'customer':'Chúc mừng. Đã tham gia Spotify Family thành công'}},
        '400' :	{'status':'Thất bại'    ,'detail':{'admin':'SYSTEM ERROR: A failure occurred when joining Premium',   'customer':'Đã có lỗi xảy ra. Vui lòng thử lại hoặc liên hệ admin'}},
        '401' :	{'status':'Thất bại'    ,'detail':{'admin':'SYSTEM ERROR: A failure occurred when accessing Spotify', 'customer':'Đã có lỗi xảy ra. Vui lòng thử lại hoặc liên hệ admin'}}, #System: Failed
        '402' :	{'status':'Thất bại'    ,'detail':{'admin':'SYSTEM ERROR: A failure occurred when switching nation',  'customer':'Đã có lỗi xảy ra. Vui lòng thử lại hoặc liên hệ admin'}},
        '403' :	{'status':'Thất bại'    ,'detail':{'admin':'ADMIN ERROR: Join link expired',                          'customer':'Đã có lỗi xảy ra. Vui lòng thử lại hoặc liên hệ admin'}}, #Admin: Join Link expired 
        '404' :	{'status':'Thất bại'    ,'detail':{'admin':'Reserved',                                                'customer':'Reserved'}},
        '405' :	{'status':'Thất bại'    ,'detail':{'admin':'ADMIN ERROR: Join link error',                            'customer':'Đã có lỗi xảy ra. Vui lòng thử lại hoặc liên hệ admin'}},
        '406' :	{'status':'Thất bại'    ,'detail':{'admin':'CUSTOMER ERROR: Incorrect username or password',          'customer':'Tài khoản hoặc mật khẩu không chính xác. Vui lòng kiểm tra lại tài khoản'}}, #Customer
        '408' : {'status':'Thất bại'    ,'detail':{'admin':'SYSTEM ERROR: Request Timeout',                           'customer':'Đã có lỗi xảy ra. Vui lòng thử lại hoặc liên hệ admin'}}, #System: Timeout
        '409' :	{'status':'Thất bại'    ,'detail':{'admin':'SYSTEM ERROR: A failure occurred in main branch',         'customer':'Đã có lỗi xảy ra. Vui lòng thử lại hoặc liên hệ admin'}},
        '410' :	{'status':'Thất bại'    ,'detail':{'admin':'ADMIN ERROR: Join Premium Family from other country',     'customer':'Đã có lỗi xảy ra. Vui lòng thử lại hoặc liên hệ admin'}},
        '411' :	{'status':'Thất bại'    ,'detail':{'admin':'ADMIN ERROR: Database is null',                           'customer':'Đã có lỗi xảy ra. Vui lòng thử lại hoặc liên hệ admin'}},
        '412' :	{'status':'Thất bại'    ,'detail':{'admin':'ADMIN ERROR: No available slot in database',              'customer':'Đã có lỗi xảy ra. Vui lòng thử lại hoặc liên hệ admin'}},
        '415' :	{'status':'Thất bại'    ,'detail':{'admin':'CUSTOMER ERROR: Wrong verification code',                 'customer':'Verification code chưa đúng. Vui lòng thử lại hoặc liên hệ admin để mua code'}},
        # Admin::
        '516' :	{'status':'Error'       ,'detail':{'admin':'ID empty',                                                'customer':'None'}},
        '517' :	{'status':'Error'       ,'detail':{'admin':'ID out of range',                                         'customer':'None'}},
        '518' :	{'status':'Error'       ,'detail':{'admin':'ID type error',                                           'customer':'None'}},
        '519' :	{'status':'Error'       ,'detail':{'admin':'Edit value empty',                                        'customer':'None'}},
        '520' :	{'status':'Error'       ,'detail':{'admin':'Permission denied',                                       'customer':'None'}},
        '530' :	{'status':'Success'     ,'detail':{'admin':'Deleted',                                                 'customer':'None'}},
        '531' :	{'status':'Success'     ,'detail':{'admin':'Editted',                                                 'customer':'None'}},
        # Others:
        '686' :	{'status':'Warning'     ,'detail':{'admin':'Warning: Others value',                                   'customer':'Warning: Others value'}},
        '999' :	{'status':'Error'       ,'detail':{'admin':'Unknow Exception',                                        'customer':'Unknow Exception'}},

    }
    
    ResponseError = {
        'database is locked'    : 'Database is locked'    # --> Database is open and not saved yet.
        # """'uploadData-name'""" : 'Choosen file is empty',
        
    }
    
    DT_format = "%d/%m/%Y %H:%M:%S"
    D_format = "%d/%m/%Y"
    
    langcode  = {
        'Japan'                   : 'JP',
        'Turkey'                  : 'TR',
        'Vietnam'                 : 'VN',
        'USA'                     : 'US',
        'India'                   : 'IN'
    }
    
class logging():
    #Attributes:
    dt_format = "%d-%m-%Y_%H.%M.%S"
    dt = datetime.datetime.now().strftime(dt_format)

    def __init__(self, user_, familyURL_, masteracc_, nation_, curdir_):
        self.user      = user_
        self.familyURL = familyURL_
        self.masteracc = masteracc_
        self.nation    = nation_
        self.curdir    = curdir_
        self.curdirpath = os.path.join(self.curdir, 'log')
        self.create_log_folder()
        self.curlogpath = os.path.join(self.curdirpath, f'Selenium_log_{datetime.datetime.now().strftime(self.dt_format)}.txt')
        self.create_log()
        
    #Methods:
    def create_log(self):
        try:
            f  = open(self.curlogpath, 'w')
            f.writelines('=========================================================================')
            f.writelines('\n============================== INFORMATION ==============================')
            f.writelines('\n=========================================================================')
            f.writelines(f'\nEmail/Phone    : {self.user}')
            f.writelines(f'\nMaster Account : {self.familyURL}')
            f.writelines(f'\nFamily URL     : {self.masteracc}')
            f.writelines(f'\nNation         : {self.nation}')
            f.writelines('\n=========================================================================')
            f.writelines('\n=========================================================================')
            f.writelines('\n=========================================================================')
            f.writelines(f'\n[{datetime.datetime.now().strftime(self.dt_format)}]: ########## START RECORDING LOG ##########')
        except Exception as e:
            print(f'Failed: {e}')

    def write_log(self, log):
        try: 
            f  = open(self.curlogpath, 'a')
            f.writelines(f'\n[{datetime.datetime.now().strftime(self.dt_format)}]: {log} ... Done')
            print(colored(f'\n[{datetime.datetime.now().strftime(self.dt_format)}]: {log} ... Done', 'yellow', attrs=["bold"]))
        except Exception as e:
            print(f'Failed: {e}')

    def close_log(self):
        try:
            f  = open(self.curlogpath, 'a')
            f.writelines(f'\n[{datetime.datetime.now().strftime(self.dt_format)}]: ########## END RECORDING LOG ##########')
        except Exception as e:
            print(f'Failed: {e}')

    def create_log_folder(self):
        try:
            os.mkdir(self.curdirpath)
        except FileExistsError:
            pass
        except Exception as e:
            print(f'Failed: {e}')
            
class Process(delay, logging):
    #Attributes:
    whoer_url    = f'https://whoer.net/fr'
    Spotify_url  = f'https://accounts.spotify.com/vi-VN/login?continue=https%3A%2F%2Fopen.spotify.com%2F'
    Profile_url  = f'https://www.spotify.com/us/account/profile/'
    TO_wait      = 30
    Element_dict = {
        'Nation_Sel'              : '''/html[1]/body[1]/div[1]/div[1]/div[1]/div[2]/div[2]/article[1]/section[1]/form[1]/div[1]/button[1]/span[1]''',
        'join_invite'             : '''//header/a[1]/span[1]''',
        'join_address'            : '''//input[@id='address']''',
        'join_expired'            : '''//html[1]/body[1]/div[1]/main[1]/div[1]/section[1]/h1[1]''',
        'onetrust_off'            : '''//body/div[@id='onetrust-consent-sdk']/div[@id='onetrust-banner-sdk']/div[1]/div[2]/button[1]''',
        'invalid_user'            : '''/html[1]/body[1]/div[1]/div[1]/div[2]/div[1]/div[1]/div[1]/span[1]''',
        'join_submit'             : '''//body/div[@id='__next']/form[1]/main[1]/div[1]/div[1]/fieldset[1]/div[1]/button[1]''',
        'ignore_addr_suggesttion' : '''/html[1]/body[1]/div[1]/form[1]/main[1]/div[1]/section[1]/fieldset[1]/div[1]/div[1]/label[1]/span[1]''',
        'continue_active_account' : '''/html[1]/body[1]/div[1]/main[1]/div[1]/div[1]/a[1]/span[1]''',
        'join_address_confirm'    : '''//body/div[@id='__next']/div[1]/div[1]/footer[1]/button[2]/span[1]''',
        'join_sucess_status'      : '''/html[1]/body[1]/div[1]/main[1]/div[1]/section[1]/div[1]/h1[1]'''
    }
    Nation_dict  = {
        'Japan'                   : 'JP',
        'Turkey'                  : 'TR',
        'Vietnam'                 : 'VN',
        'USA'                     : 'US',
        'India'                   : 'IN'
    }
    Expired_list         = ['Liên kết đó đã hết hạn',  'That link has expired' ,'Bu bağlantının süresi doldu.']
    Error_list           = ['Đã xảy ra lỗi', 'An error occurred', 'Analňyşlyk ýüze çykdy']
    Invalid_list         = ['Tên người dùng hoặc mật khẩu không chính xác.','Incorrect username or password.','Kullanıcı adı veya parola yanlış.']
    # Có vẻ như bạn đang cố tham gia Premium Family từ một quốc gia khác. 
    # Premium Family chỉ dành cho các thành viên gia đình sống cùng nhau. 
    # Hãy thử lại khi bạn cũng ở địa chỉ đó.
    Invalid_address_list = [
                            'Có vẻ như bạn đang cố tham gia Premium Family từ một quốc gia khác.',
                            '''You need to live at the same address''',
                            ] 

    def __init__(self, user_, password_, familyURL_, address_, nation_, log_):
        self.user      = user_
        self.password  = password_
        self.familyURL = familyURL_
        self.address   = str(address_).replace('__',' ')
        self.nation    = str(nation_).upper()
        self.log       = log_

    #Methods:
    def accessSpotify(self, driver):
        try:
            driver.get(self.Spotify_url)
            self.log.write_log(f'In {self.accessSpotify.__name__} - Start accessing Spotify')
            WebDriverWait(driver, self.TO_wait).until(EC.visibility_of_element_located((By.ID ,'login-username'))).send_keys(self.user)
            WebDriverWait(driver, self.TO_wait).until(EC.visibility_of_element_located((By.ID ,'login-password'))).send_keys(self.password)
            WebDriverWait(driver, self.TO_wait).until(EC.visibility_of_element_located((By.ID ,'login-button'))).click()
            self.log.write_log(f'In {self.accessSpotify.__name__} - Tried to insert username/password')
            sleep(self.DELAY) #MUST!
            self.log.write_log(f'In {self.accessSpotify.__name__} - Waiting to check validation')
            ret = self.userCheck(driver)
            self.log.write_log(f'''In {self.accessSpotify.__name__} - Username is "{ret}"''')
            #Return:
            return ret
        except TimeoutException as e:
            self.log.write_log(f'In {self.accessSpotify.__name__} - Timeout: {e}')
            self.log.close_log()
            return f'Timeout: {e}'
        except Exception as e:
            self.log.write_log(f'In {self.accessSpotify.__name__} - Failure: {e}')
            self.log.close_log()
            return f'Failure: {e}'
    
    def userCheck(self, driver):
        try:
            for text in self.Invalid_list:
                if self.checkText(driver, text,'Usercheck'):
                    return 'Invalid'
            return 'Valid'
        except Exception as e:
            return f'Failure: {e}'
        
    def addressCheck(self, driver):
        try:
            for text in self.Invalid_address_list:
                if self.checkText(driver, text,'Addresscheck'):
                    return 'Invalid'
            return 'Valid'
        except Exception as e:
            return f'Failure: {e}'

    def switchNation(self, driver):
        try:
            driver.get(self.Profile_url)
            self.log.write_log(f'In {self.switchNation.__name__} - Start switching Nation')
            select = Select(WebDriverWait(driver, self.TO_wait).until(EC.presence_of_element_located((By.ID, 'country'))))
            select.select_by_value(self.nation)
            self.log.write_log(f'In {self.switchNation.__name__} - Selected Nation')
            try:    WebDriverWait(driver, self.TO_wait).until(EC.element_to_be_clickable((By.XPATH, self.Element_dict['onetrust_off']))).click() #if-any
            except: pass
            self.log.write_log(f'In {self.switchNation.__name__} - Closed Onetrust')
            WebDriverWait(driver, self.TO_wait).until(EC.element_to_be_clickable((By.XPATH, self.Element_dict['Nation_Sel']))).click()
            self.log.write_log(f'In {self.switchNation.__name__} - Saved profile')
            sleep(self.DELAY) #MUST!
            self.log.write_log(f'In {self.accessSpotify.__name__} - Waiting to check Nation validation')
            #Return:
            return 'Success'
        except TimeoutException as e:
            self.log.write_log(f'In {self.switchNation.__name__} - Timeout: {e}')
            self.log.close_log()
            return f'Timeout: {e}'
        except Exception as e:
            self.log.write_log(f'In {self.switchNation.__name__} - Failure: {e}')
            self.log.close_log()
            return f'Failure: {e}'
        
    def joinPremium(self, driver):
        try:
            out = False
            driver.get(self.familyURL) 
            self.log.write_log(f'In {self.joinPremium.__name__} - Start joining Premium family')
            sleep(self.FLEX_DELAY)
            self.log.write_log(f'In {self.joinPremium.__name__} - Checking for expired join link')
            for text in self.Expired_list:
                if self.checkText(driver, text,'Joinfamily_Expire'): 
                    out = 'Joinfamily_Expire' 
                    break 
            for text in self.Error_list:
                if self.checkText(driver, text,'Joinfamily_Error'): 
                    out = 'Joinfamily_Error' 
                    break 
            if out == 'Joinfamily_Expire': 
                self.log.write_log(f'In {self.joinPremium.__name__} - Join link expired')
                return 'Join Link expired'
            elif out == 'Joinfamily_Error': 
                self.log.write_log(f'In {self.joinPremium.__name__} - Join link error')
                return 'Join Link error'
            else:
                WebDriverWait(driver, self.TO_wait).until(EC.visibility_of_element_located((By.XPATH, self.Element_dict['join_invite']))).click()
                self.log.write_log(f'In {self.joinPremium.__name__} - Accepted invite')
                WebDriverWait(driver, self.TO_wait).until(EC.visibility_of_element_located((By.XPATH, self.Element_dict['continue_active_account']))).click()
                self.log.write_log(f'In {self.joinPremium.__name__} - Continued with active account')
                WebDriverWait(driver, self.TO_wait).until(EC.visibility_of_element_located((By.XPATH, self.Element_dict['join_address']))).send_keys(self.address)
                self.log.write_log(f'In {self.joinPremium.__name__} - Inserted address string')
                WebDriverWait(driver, self.TO_wait).until(EC.visibility_of_element_located((By.XPATH, self.Element_dict['ignore_addr_suggesttion']))).click()
                self.log.write_log(f'In {self.joinPremium.__name__} - Ignored the address suggestion')
                WebDriverWait(driver, self.TO_wait).until(EC.visibility_of_element_located((By.XPATH, self.Element_dict['join_submit']))).click()
                self.log.write_log(f'In {self.joinPremium.__name__} - Tried to find address')
                WebDriverWait(driver, self.TO_wait).until(EC.visibility_of_element_located((By.XPATH, self.Element_dict['join_address_confirm']))).click()
                sleep(self.MASSIVE_DELAY) #MUST!
                if self.addressCheck(driver) == 'Valid':
                    self.log.write_log(f'In {self.joinPremium.__name__} - Confirm the inserted address')
                    self.log.write_log(f'In {self.joinPremium.__name__} - Join Family successfully')
                    self.log.close_log()
                    sleep(self.DELAY) #MUST!
                    #Return:
                    return 'Success'
                else:
                    self.log.write_log(f'In {self.joinPremium.__name__} - Wrong nation address')
                    self.log.close_log()
                    sleep(self.DELAY) #MUST!
                    #Return:
                    return 'Wrong nation address'
                
        except TimeoutException as e:
            self.log.write_log(f'In {self.joinPremium.__name__} - Timeout: {e}')
            self.log.close_log()
            return f'Timeout: {e}'
        except Exception as e:
            self.log.write_log(f'In {self.joinPremium.__name__} - Failure: {e}')
            self.log.close_log()
            return f'Failure: {e}'
        
    @classmethod
    def checkCurrentIP(cls, driver):
        driver.get(cls.whoer_url)

    @classmethod
    def checkText(self, driver, text, option=None):
        if option == 'Joinfamily_Expire':     OCCUR = 1
        elif option == 'Joinfamily_Error':    OCCUR = 1
        elif option == 'Usercheck':           OCCUR = 0
        elif option == 'Addresscheck':        OCCUR = 1
        else:                                 OCCUR = 0  
        ps = driver.page_source
        if (text in driver.page_source) and (self.Occurrences(text, ps) > OCCUR): return True
        else:                                                                     return False

    @classmethod
    def Occurrences(self, str_, ps_):
        counts = str(ps_).count(str_)
        return counts

    #ANCHOR - Test:
    def accessSpotify_Test(self, driver):
        try:
            driver.get(self.Spotify_url)
            driver.maximize_window()
            sleep(self.DELAY)
            driver.find_element(By.ID ,'login-username').send_keys(self.user)
            driver.find_element(By.ID ,'login-password').send_keys(self.password)
            # sleep(self.DELAY)
            driver.find_element(By.ID ,'login-button').click()
            sleep(self.DELAY)
            driver.get(self.Profile_url)
            sleep(self.HARD_DELAY)
            print(driver.page_source) 
            # sleep(self.DELAY)
            #Return:
            return 'passed'
        except Exception as e:
            return f'Failure: {e}'
        
#Instance:
Ins       = Process('dummy_1', 'dummy_2', 'dummy_3', 'dummy_4', 'dummy_5', 'dummy_6')
ResConfig = ResponseConfig()

