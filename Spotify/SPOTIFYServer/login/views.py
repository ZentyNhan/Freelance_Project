########## SECTION: Library ##########
import sys
import os
from contextlib import nullcontext
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

#Lib:
import login.static.lib as lib

#DJANGO:
from django.shortcuts import render
from django.http import HttpResponse
from login.models import MainDB


########## ANCHOR: DATA ##########
ResponseCode = {
    '200' :	{'status':'Thành công'  ,'detail':'Tham gia Spotify Family thành công'},
    '400' :	{'status':'Thất bại'    ,'detail':'Tham gia Spotify Family thất bại'},
    '401' :	{'status':'Thất bại'    ,'detail':'Đăng nhập không thành công'},
    '402' :	{'status':'Thất bại'    ,'detail':'Chuyển quốc gia không thành công'},
    '403' :	{'status':'Thất bại'    ,'detail':'Liên kết tham gia đã hết hạn'},
    '404' :	{'status':'Thất bại'    ,'detail':'Tham gia Spotify Family thất bại'},
    '405' :	{'status':'Thất bại'    ,'detail':'Tham gia Premium Family từ một quốc gia khác'},
    '406' :	{'status':'Thất bại'    ,'detail':'Tài khoản hoặc mật khẩu không chính xác'},
    '408' : {'status':'Thất bại'    ,'detail':'Request Timeout'},
    '409' :	{'status':'Thất bại'    ,'detail':'Thất bại, không thể thực hiện được'}
}
ResponseProg = {
    
}
########## ANCHOR: METHOD ##########
def ret_dict_met(stt_, detl_):
    return {"status": stt_, "detail": detl_,"time" : datetime.datetime.now().strftime("%d/%m/%Y %H:%M:%S")}

########## ANCHOR: VIEWS ##########
# Create your views here.
def get_login(request):
    return render(request, 'login.html')

# def DB_Input_TEST(User_,PassW_,FamLink_,Addr_,isJoin_,Detail_):
    # UserInfo = SpotifyDB(1,User_, PassW_, FamLink_, Addr_, isJoin_, Detail_)
    # UserInfo.save()

def joinSpotify(request):
    if request.method == 'POST':
        #Get info from customer:
        UserN = request.POST.get('Uname')
        PassW = request.POST.get('Pwd')
        
        if UserN in ""  or PassW in "" :
            ret_dict = ret_dict_met("Lỗi" , "Tài khoản và mật khẩu không được để trống")
            return render(request, 'login.html',ret_dict)
        else:
            try: 
                ########## ANCHOR: DO NOT CHANGE ##########
                # #Get information from PHP:
                Username    = UserN
                Password    = PassW
                familyURL   = 'https://www.spotify.com/vn-vi/family/join/invite/x69cx223A8cbcbY/'
                Address     = 'Binbirdirek, Peykhane Cd. 10/A, 34122 Fatih/İstanbul, Türkiye'
                Nation      = 'VN'
                
                #String Handling:
                dt_format  = "%d-%m-%Y_%H:%M:%S"
                ls         = familyURL.split('/')
                Ind        = ls.index('invite') + 1
                Premium_ID = ls[Ind]
                length     = len(MainDB.objects.all().values()) 
                id         = length + 1 #Calculate ID from current length Users in DB:
                
                #TEST DB:
                UserInfo = MainDB(id, Username, Password, familyURL, Address, True, ResponseCode['200']['detail'])
                UserInfo.save()
                mydata = MainDB.objects.all().values()
                print(mydata)
                
                #Instances:
                ops = webdriver.ChromeOptions()
                # ops.add_argument('headless')
                DRIVER         = webdriver.Chrome(ChromeDriverManager().install(), options=ops)
                LOGGING        = lib.logging(os.getcwd())
                USER           = lib.Process(Username, Password, familyURL, Address, Nation, LOGGING)
                code           = '400'
                failure        = ['Failure', 'Timeout']
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
                            #Update on DB:
                            UserInfo = MainDB(Username, Password, familyURL, Address, True, ResponseCode[code]['detail'])
                            UserInfo.save()
                        elif Status in 'Join Link expired':
                            code     = '403'
                        else: 
                            code     = '400'
                    elif Debug_2 in 'Join Link expired':
                        code     = '403'
                    elif Debug_2 in 'Wrong nation address':
                        code     = '405'
                    else:
                        code     = '402'
                elif Debug_1 in 'Invalid':
                    code     = '406'
                else:
                    code     = '401'
                #Close driver:
                DRIVER.close()
                
                #Check ret
                if Debug_1[:7] in failure[1] or \
                    Debug_2[:7] in failure[1] or \
                    Status[:7] in failure[1]:
                    ret_dict = ret_dict_met(ResponseCode['408']['status'], ResponseCode['408']['detail'])
                else:
                    ret_dict = ret_dict_met(ResponseCode[code]['status'], ResponseCode[code]['detail'])
                    

            #Timeout:
            except TimeoutException as error:
                ret_dict = ret_dict_met(ResponseCode['408']['status'], ResponseCode['408']['detail'])
            #Others:
            except:
                ret_dict = ret_dict_met(ResponseCode['409']['status'], ResponseCode['409']['detail'])
            
            #Return: 
            return render(request, 'login.html',ret_dict)
    else:
        #Return: 
        return render(request, 'login.html')

def get_test(request):
    return render(request, 'test.html')

def get_test_rep(request):
    return HttpResponse()