########## SECTION: Library ##########
import sys
import os
from multipledispatch import dispatch
from contextlib import nullcontext
from pickle import FALSE, TRUE
from subprocess import check_output
from webdriver_manager.chrome import ChromeDriverManager #Window flatform only
from seleniumwire import webdriver
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.select import Select
from selenium.webdriver.chrome.service import Service
from selenium.common.exceptions import TimeoutException
from selenium.common.exceptions import NoSuchElementException,ElementNotInteractableException,ElementClickInterceptedException
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
import xlsxwriter
from io import BytesIO

#Lib:
import login.static.lib as lib

#DJANGO:
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required
from django.contrib import messages
from django.shortcuts import render, redirect
from django.http import HttpResponse
from login.models import MainDB, MasterAccountDB, VerificationCodeDB, StoredDB, ProxyManamentDB
from tablib import Dataset
from django.http import JsonResponse

########## ANCHOR: GLOBAL ATTIRIBUTES ##########

Max_join_memnum = int(5)
ret_dict        = {}
DT_format       = "%d/%m/%Y %H:%M:%S"
D_format        = "%d/%m/%Y"
DTRes_format    = "%H:%M:%S - %d/%m/%Y "

########## ANCHOR: GLOBAL METHODS ##########
@dispatch(dict)
def ret_dict_met(dict_):
    return {"data": dict_}

@dispatch(str,str)
def ret_dict_met(stt_, detl_):
    return {"status": stt_, "detail": detl_,"time" : current_datetime()}

@dispatch(str,str,list)
def ret_dict_met(stt_, detl_, table_):
    return {"status": stt_, "detail": detl_,"time" : current_datetime(),"table":table_}

@dispatch(str,str,dict)
def ret_dict_met(stt_, detl_, table_):
    return {"status": stt_, "detail": detl_,"time" : current_datetime(),"table":table_}

@dispatch(str,str,list,int) #Vercode
def ret_dict_met(stt_, detl_, table_, valid_amount_):
    return {"status": stt_, "detail": detl_,"time" : current_datetime(), "table":table_,"valid_amount":valid_amount_}

@dispatch(str,str,str,list)
def ret_dict_met(stt_, detl_, actnation_, table_):
    return {"status": stt_, "detail": detl_,"time" : current_datetime(),"ActiveNation" : actnation_,"table" : table_}

@dispatch(str,str,str,dict)
def ret_dict_met(stt_, detl_, actnation_, table_): #Proxy
    return {"status": stt_, "detail": detl_,"time" : current_datetime(),"ActiveNation" : actnation_,"table" : table_}

@dispatch(str,str,str,list,int) #Vercode
def ret_dict_met(stt_, detl_, actnation_, table_, valid_amount_):
    return {"status": stt_, "detail": detl_,"time" : current_datetime(),"ActiveNation" : actnation_,"table":table_,"valid_amount":valid_amount_}

def DB_VC_list():
    rawdata = list(VerificationCodeDB.objects.all().values())
    return rawdata   

def DB_M_list():
    rawdata = list(MainDB.objects.all().values())
    return rawdata   

def DB_VC_Valid_amount():
    valid_amount = 0
    rawdata = list(VerificationCodeDB.objects.all().values())
    for i in rawdata:
        if i['Status'] == 'valid':
            valid_amount += 1
    return valid_amount

def DB_Input(id_,User_,  PassW_, MasterAcc_, FamLink_, Addr_, vercode_, isJoin_, Detail_):
    UserInfo = MainDB(id_, User_, PassW_, MasterAcc_, FamLink_, Addr_, vercode_, isJoin_, Detail_,current_datetime())
    UserInfo.save()
    
def DB_upload(id_, User_, FamLink_, Addr_, Nation_, Memnum_, Date_):
    if Date_ in [None, 'None', '']:    
        Date_ = current_datetime()
    MasterUserInfo = MasterAccountDB(id_, User_, FamLink_, Addr_, Nation_, Memnum_ , Date_)
    MasterUserInfo.save()
    
def DB_Proxy_upload(id_, Protocol_, IP_, ProxyUser_, ProxyPW_, Nation_, ActDate_):
    if ActDate_ in [None, 'None', '']:    
        ActDate_ = current_date()
    ProxyInfo = ProxyManamentDB(id_, Protocol_, IP_, ProxyUser_, ProxyPW_, Nation_, ActDate_)
    ProxyInfo.save()
    
def DB_gencode(id_, Vercode_, Status_, Remark_):
    VerificationCode = VerificationCodeDB(id_, Vercode_, Status_, Remark_)
    VerificationCode.save()
    
def DB_get_master_info():
    DB_MA_rawdata  = list(MasterAccountDB.objects.all().values())
    DB_AN_rawdata     = StoredDB.objects.all().values()
    
    isSlotAvaiable    = False
    if DB_MA_rawdata != []:
        datetime.datetime.strptime("1/1/9999", lib.ResConfig.D_format)
        min_created_date = datetime.datetime.strptime("1/1/9999", lib.ResConfig.D_format)
        for master_info in DB_MA_rawdata:
            if master_info['MemNum'] != 0 and \
               master_info['Nation'] == DB_AN_rawdata[0]['ActiveNation'] and \
               datetime.datetime.strptime(master_info['Date'], lib.ResConfig.D_format) <= min_created_date :
                isSlotAvaiable   = True
                min_created_date = datetime.datetime.strptime(master_info['Date'], lib.ResConfig.D_format)
                id_              = master_info['id']
                MasterAcc_       = master_info['Username']
                familyURL_       = master_info['FamLink']
                Address_         = master_info['Address']
                NemNum_          = master_info['MemNum']
                Nation_          = master_info['Nation']       
        if isSlotAvaiable:
            return [id_,MasterAcc_,familyURL_,Address_,NemNum_,Nation_]
        else:
            return 'No available slot'
    else:
        return 'Database is null'
    
def DB_M_succeed_table(code_):
    ### Input ###
    DB_M_rawdata      = MainDB.objects.all().values()
    DB_MA_rawdata     = MasterAccountDB.objects.all().values()
    succeed_MA_list   = []
    succeed_Mem_list  = []
    succeed_ID_list   = []
    succeed_VC_list   = []
    succeed_data_dict = {}
    
    #code handlling:
    code_ = '532' if code_ == '' else code_
        
    #Data in excel:
    if DB_M_rawdata == []:
        return {}
    elif DB_MA_rawdata == []:
        code = '521'
        ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'])
        return ret_dict
    #Customter's requirement format:
    else:
        #Get Master accounts in succeed cases:
        for data_1 in DB_M_rawdata:
            if data_1['MasterAccout'] not in succeed_MA_list and \
                data_1['isJoined'] == True:
                succeed_MA_list.append(data_1['MasterAccout'])
        
        #Get export account family data:
        for MA in DB_MA_rawdata:
            id = MA['id']
            if MA['Username'] in succeed_MA_list:
                for data_2 in DB_M_rawdata:
                    if MA['Username']  == data_2['MasterAccout'] and \
                        data_2['isJoined'] == True:
                            succeed_ID_list.append(data_2['id'])
                            succeed_Mem_list.append(data_2['Username'])
                            succeed_VC_list.append(data_2['VerCode'])
                            LinkJoin      = data_2['FamLink'] 
                            Address       = data_2['Address'] 
                            MasterAccount = MA['Username']
                            Nation        = lib.ResConfig.langcode[MA['Nation']]
                            #Get Created date:
                            try:
                                DB_MA_rawdata = MasterAccountDB.objects.get(Username=data_2['MasterAccout'])
                                Created_Date = DB_MA_rawdata.Date
                            except MasterAccountDB.MultipleObjectsReturned: 
                                code = '522'
                                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'])
                                return ret_dict
                            except MasterAccountDB.DoesNotExist: 
                                code = '523'
                                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'])
                                return ret_dict
                Full_zip      = {k: {v1:v2} for k, v1, v2 in zip(succeed_ID_list.copy(), succeed_Mem_list.copy(), succeed_VC_list.copy())}  
                joined_memnum = len(succeed_Mem_list)          
                
            else:
                MasterAccount = MA['Username']
                LinkJoin      = MA['FamLink']
                Address       = MA['Address']
                Nation        = lib.ResConfig.langcode[MA['Nation']]
                Created_Date  = MA['Date']
                joined_memnum = 0
                Full_zip      = 'null'

                
            #succeed_data_dict:
            succeed_data_dict[id] = {
                'MasterAccount': MasterAccount,
                'Linkjoin'     : LinkJoin,
                'Address'      : Address,
                'Nation'       : Nation,
                'MemNum'       : joined_memnum,
                'Zip'          : Full_zip,
                'Date'         : Created_Date,
            }
            succeed_VC_list.clear()
            succeed_Mem_list.clear()
            succeed_ID_list.clear()

        #ret_dict:
        ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code_]['status'], lib.ResConfig.ResponseCode[code_]['detail']['admin'], succeed_data_dict)
    #Return:         
    return ret_dict

def DB_Proxy_table(code_):
    ### Input ###
    DB_Proxy_rawdata = ProxyManamentDB.objects.all().values()
    proxy_dict       = {}
    
    #code handlling:
    code_ = '532' if code_ == '' else code_
        
    #Data in excel:
    if DB_Proxy_rawdata == []:
        return {}
    else:
        #Load proxy data:
        for proxy in DB_Proxy_rawdata:
            ID             = proxy['id']
            PROTOCOL       = proxy['Protocol']
            IP             = proxy['IP']
            PROXY_USER     = proxy['Proxy_User']
            PROXY_PW       = proxy['Proxy_PW']
            NATION         = proxy['Nation']
            ACTIVATED_DATE = proxy['Nation']
        
            #proxy_data_dict:
            proxy_dict[ID] = {
                'Protocol'      : PROTOCOL,
                'IP'            : IP,
                'Proxy_User'    : PROXY_USER,
                'Proxy_PW'      : PROXY_PW,
                'Nation'        : NATION,
                'ActivetedDate' : ACTIVATED_DATE,
            }
        #ret_dict:
        ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code_]['status'], lib.ResConfig.ResponseCode[code_]['detail']['admin'], DB_ActiveNation(), proxy_dict)
    #Return:         
    return ret_dict

def DB_check_vercode_validation(vercode_):
    vercode_info_list  = list(VerificationCodeDB.objects.all().values())
    for data in vercode_info_list:
        if data['Status'] == 'valid' and\
           str(data['VerCode']) == str(vercode_):
            return 'Valid'
    return 'Invalid'

def is_integer(n):
    if isinstance(n, int): return True
    else:                  return False
    
def id_gen(mode_, list_):
    ID = []
    data = list_
    for i in data:
        ID.append(i['id'])
    if mode_ == 'new':
        if ID == []: id = 0
        else:        id = max(ID) + 1
    elif mode_ == 'max':
        if ID == []: id = 0
        else:        id = max(ID)
    else:
        if ID == []: id = 0
        else:        id = min(ID)
    return id

def DB_ActiveNation():
    DB_AN_rawdata = StoredDB.objects.all().values()
    return str(DB_AN_rawdata[0]['ActiveNation'])
    
def current_date():
    return datetime.datetime.now().strftime(D_format)        

def current_datetime():
    return datetime.datetime.now().strftime(DT_format) 
      
def current_resdatetime():
    return datetime.datetime.now().strftime(DTRes_format)        

########## ANCHOR: VIEWS ##########
# Create your views here.

### PAGES ###
def AdminSpotify(request):
    if request.method == 'POST':
        AD_UserN = request.POST.get('uname')
        AD_PassW = request.POST.get('psw')
        AD_User = authenticate(username=AD_UserN, password=AD_PassW)
        if AD_UserN in ""  or AD_PassW in "" :
            ret_dict = ret_dict_met('Error: ', 'username or password can not be blank')
            return render(request, 'Spotify_admin.html', ret_dict)
        elif AD_User is not None:
            login(request, AD_User)
            return redirect('ControlPanel')
        else:
            ret_dict = ret_dict_met('Error: ', 'incorrect username or password. Please try again!')
            return render(request, 'Spotify_admin.html', ret_dict)
    else:
        return render(request, 'Spotify_admin.html')

########## ANCHOR: joinSpotify ########## 
def joinSpotify(request):
    if request.method == 'POST':
        #Get info from customer:
        UserN   = request.POST.get('Uname')
        PassW   = request.POST.get('Pwd')
        Vercode = request.POST.get('Vercode')
        
        #Check vercode validation:
        VC_result = DB_check_vercode_validation(Vercode)

        #Process:
        if UserN in "" or PassW in "" or Vercode in "":
            ret_dict = ret_dict_met("Lỗi" , "Xin hãy điền đầy đủ thông tin")
            return render(request, 'Spotify_login.html',ret_dict)
        else:
            try: 
                ########## DO NOT CHANGE ##########
                ### Check information from DB:
                # id handling:
                id = id_gen(mode_='new', list_=MainDB.objects.all().values()) #Calculate ID from current length Users in DB
                # get master information:
                Master_infor = DB_get_master_info()
                if  Master_infor in ['Database is null']:
                    code = '411'
                    ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['customer'])
                    DB_Input(id, UserN, PassW, 'null', 'null', 'null', Vercode, False, lib.ResConfig.ResponseCode[code]['detail']['admin'])
                elif  Master_infor in ['No available slot']:
                    code = '412'
                    ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['customer'])
                    DB_Input(id, UserN, PassW, 'null', 'null', 'null', Vercode, False, lib.ResConfig.ResponseCode[code]['detail']['admin'])
                elif VC_result == 'Invalid':
                    code = '415'
                    ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['customer'])
                    DB_Input(id, UserN, PassW, 'null', 'null', 'null', Vercode, False, lib.ResConfig.ResponseCode[code]['detail']['admin'])
                else:
                    # Customer information:
                    Username    = UserN
                    Password    = PassW
                    Master_id   = Master_infor[0]
                    MasterAcc   = Master_infor[1]
                    familyURL   = Master_infor[2]
                    Address     = Master_infor[3]
                    MemNum      = Master_infor[4] #Current member number.
                    Nation      = Master_infor[5]
                    
                    #String Handling:
                    dt_format  = "%d-%m-%Y_%H:%M:%S"
                    ls         = familyURL.split('/')
                    Ind        = ls.index('invite') + 1
                    Premium_ID = ls[Ind]
                    
                    #proxy:
                    IND = 0
                    NAT = 'Indian'
                    
                    #Instances:
                    #Options and services:
                    ops  = webdriver.ChromeOptions()
                    ops.add_argument('headless')
                    serv = Service()
                    # options = {
                    #     'proxy': {
                    #         'http':  '{0}://{1}:{2}@{3}'.format(lib.proxy.info[NAT][IND]['protocol'], lib.proxy.info[NAT][IND]['User'], lib.proxy.info[NAT][IND]['PW'], lib.proxy.info[NAT][IND]['IP']),
                    #         'https': '{0}://{1}:{2}@{3}'.format(lib.proxy.info[NAT][IND]['protocol'], lib.proxy.info[NAT][IND]['User'], lib.proxy.info[NAT][IND]['PW'], lib.proxy.info[NAT][IND]['IP']),
                    #         'no_proxy': 'localhost,127.0.0.1'
                    #     }
                    # }
                    try:
                        DRIVER         = webdriver.Chrome(ChromeDriverManager().install(),options= ops, seleniumwire_options=ops)
                    except:
                        DRIVER         = webdriver.Chrome(service=serv, options=ops, seleniumwire_options=ops)
                    LOGGING        = lib.logging(Username, familyURL, MasterAcc, Nation, os.getcwd())
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
                            elif Status in 'Wrong nation address':
                                code     = '410'
                            elif Status in 'Join Link expired':
                                code     = '403'
                            elif Status in 'Join Link error':
                                code     = '405'
                            else: 
                                code     = '400'
                        elif Debug_2 in 'Join Link expired':
                            code     = '403'
                        else:
                            code     = '402'
                    elif Debug_1 in 'Invalid':
                        code     = '406'
                    else:
                        code     = '401'
                    #Close driver:
                    DRIVER.close()
                    
                    ########## REPORT AND DB HANDLING ##########
                    ##### "SUCCESS" TEST: #####
                    # code = '200'
                    ###########################
                    
                    ### Check error ret: ###
                    if Debug_1[:7] in failure[1] or \
                        Debug_2[:7] in failure[1] or \
                        Status[:7] in failure[1]:
                        code = '408'
                        ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['customer'])
                    else:
                        ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['customer'])
                    
                    ### Update on DB: ###
                    if code == '200': 
                        DB_Input(id, Username, Password, MasterAcc, familyURL, Address, Vercode, True, lib.ResConfig.ResponseCode[code]['detail']['admin'])
                        #Update member number:
                        Update_MA_DB = MasterAccountDB.objects.get(id=Master_id)
                        Update_MA_DB.MemNum = int(MemNum) - 1
                        Update_MA_DB.save()
                        #Update vercode to Used:
                        Update_VC_DB = VerificationCodeDB.objects.get(VerCode=Vercode)
                        Update_VC_DB.Status = 'used'
                        Update_VC_DB.Remark = f'''Used by User "{Username}" on {current_datetime()}'''
                        Update_VC_DB.save()
                    elif code == '403':
                        DB_Input(id, Username, Password, MasterAcc, familyURL, Address, Vercode, True, lib.ResConfig.ResponseCode[code]['detail']['admin'])
                        #Update member number:
                        Update_MA_DB = MasterAccountDB.objects.get(id=Master_id)
                        Update_MA_DB.MemNum = 0
                        Update_MA_DB.Remark = '### Join Link expired ###\nPlease check and update join link'
                        Update_MA_DB.save()
                    elif code == '405':
                        DB_Input(id, Username, Password, MasterAcc, familyURL, Address, Vercode, True, lib.ResConfig.ResponseCode[code]['detail']['admin'])
                        #Update member number:
                        Update_MA_DB = MasterAccountDB.objects.get(id=Master_id)
                        Update_MA_DB.MemNum = 0
                        Update_MA_DB.Remark = '### Join Link error ###\nPlease check and update join link'
                        Update_MA_DB.save()
                    else:             
                        DB_Input(id, Username, Password, MasterAcc, familyURL, Address, Vercode, False, lib.ResConfig.ResponseCode[code]['detail']['admin'])
                
            ########## EXCEPTIONS ##########
            #Timeout:
            except TimeoutException as error:
                code = '408'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['customer'])
                DB_Input(id, Username, Password, MasterAcc, familyURL, Address, Vercode, False, lib.ResConfig.ResponseCode[code]['detail']['admin'])
            # Others:
            except Exception as e:
                code = '409'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['customer'])
                DB_Input(id, Username, Password, MasterAcc, familyURL, Address, Vercode, False, lib.ResConfig.ResponseCode[code]['detail']['admin'])
                
            #Return: 
            return render(request, 'Spotify_login.html',ret_dict)
    else:
        #Return: 
        return render(request, 'Spotify_login.html')
    
### ANCHOR: EVENTS ### 
########## ANCHOR: DeleteAccount ##########: Delete
@login_required(login_url='/Spot-admin')
def DeleteAccount(request):
    try:
        ### Input ###  
        M_list   = DB_M_list()
        #Get info from admin:
        input_id = request.POST.get('id') #str
        #Others:
        A_ID     = []
        
        ### Functions ###
        for i in M_list:
            #Get VC id info:
            A_ID.append(i['id'])
        
        if int(input_id) in A_ID:
            #Delete object:
            MainDB.objects.get(id=input_id).delete()
            #Update objects order:
            code     = '530' 
            ret_dict = DB_M_succeed_table(code)
            return JsonResponse(ret_dict, status=200)
        else:
            code     = '529'
            ret_dict = DB_M_succeed_table(code)
            return JsonResponse(ret_dict, status=404)
            
    except:
        code     = '999'
        ret_dict = DB_M_succeed_table(code)
        return JsonResponse(ret_dict, status=404)
    
########## ANCHOR: DeleteCode ##########: Delete 
@login_required(login_url='/Spot-admin')
def DeleteCode(request):
    try:
        ### Input ###  
        VC_list  = DB_VC_list()
        #Get info from admin:
        input_id = request.POST.get('id') #str
        #Others:
        VC_ID    = []

        ### Functions ###
        for i in VC_list:
            #Get VC id info:
            VC_ID.append(i['id'])
        
        if int(input_id) in VC_ID:
            #Delete object:
            VerificationCodeDB.objects.get(id=input_id).delete()
            #Update objects order:
            Update_VC_list = DB_VC_list()
            code = '530'
            ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], Update_VC_list, DB_VC_Valid_amount())
            return JsonResponse(ret_dict, status=200)
        else:
            code = '686'
            ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], VC_list, DB_VC_Valid_amount())
            return JsonResponse(ret_dict, status=404)
            
    except:
        code = '999'
        ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], VC_list, DB_VC_Valid_amount())
        return JsonResponse(ret_dict, status=404)
    
########## ANCHOR: ChangeNation ##########: Change
@login_required(login_url='/Spot-admin')
def ChangeNation(request):
    try:
        ### Input ###  
        act_nation = request.POST.get('ActNationSel_n')
        Update = StoredDB.objects.get(id = 1)
        
        #Update Active Nation:
        Update.ActiveNation = act_nation
        Update.save()
        code     = '532' 
        ret_dict = DB_M_succeed_table(code)
        return JsonResponse(ret_dict, status=200)
            
    except:
        code     = '999' 
        ret_dict = DB_M_succeed_table(code)
        return JsonResponse(ret_dict, status=404)

#(***OBSOLETED***)
########## ANCHOR: UpdateCode ##########: Update / Delete / Edit 
@login_required(login_url='/Spot-admin')
def UpdateCode(request):
    try:
        ### Input ###  
        VC_list          = DB_VC_list()
        #Get info from admin:
        input_id         = request.POST.get('cid-input-name') #str
        input_edit_value = request.POST.get('VClistedit_n')   #str
        #Others:
        length           = len(VerificationCodeDB.objects.all().values())
        isUsedCode       = False
        VC_ID            = []
        VC_ID_RANGE      = []

        ### Functions ###
        #Get VC id info and check if used code:
        for i in VC_list:
            #Get VC id info:
            VC_ID.append(i['id'])
            #Check if used code:
            if str(i['id']) == input_id and \
               i['Status'] == 'used':
                isUsedCode = True
        
        #id input handling: is_integer
        if ":" in input_id and str(input_id).count(':') == 1:
            lim     = str(input_id).split(':')
            lim_max = int(max(lim))
            lim_min = int(min(lim))
            for i in VC_ID:
                if i <= lim_max and i >= lim_min:
                    VC_ID_RANGE.append(int(i))
        elif input_id == 'all':
            VC_ID_RANGE = VC_ID
        else:
            pass

        #Update list:
        if 'ul-btn-n' in request.POST: 
            ret_dict = {'table' : VC_list, 'valid_amount' : DB_VC_Valid_amount()}

        #Delete list:
        elif 'dl-btn-n' in request.POST: 
            if input_id == '':
                code = '516'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], VC_list, DB_VC_Valid_amount())
            elif set(VC_ID_RANGE).issubset(set(VC_ID)) and VC_ID_RANGE != []:
                #Delete object:
                for id_i in VC_ID_RANGE:
                    VerificationCodeDB.objects.get(id=id_i).delete()
                #Update objects order:
                Update_VC_list = DB_VC_list()
                code = '530'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], Update_VC_list, DB_VC_Valid_amount())
            elif int(input_id) not in VC_ID:
                code = '517'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], VC_list, DB_VC_Valid_amount())
            elif int(input_id) in VC_ID:
                #Delete object:
                VerificationCodeDB.objects.get(id=input_id).delete()
                #Update objects order:
                Update_VC_list = DB_VC_list()
                code = '530'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], Update_VC_list, DB_VC_Valid_amount())
            else:
                code = '686'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], VC_list, DB_VC_Valid_amount())
                
        #Edit list:
        elif 'el-btn-n' in request.POST and isUsedCode == False: 
            if input_id == '':
                code = '516'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], VC_list, DB_VC_Valid_amount())
            elif set(VC_ID_RANGE).issubset(set(VC_ID)) and VC_ID_RANGE != []:
                #Edit object:
                for id_i in VC_ID_RANGE:
                    Update_VC_Object = VerificationCodeDB.objects.get(id=id_i)
                    Update_VC_Object.Status = input_edit_value
                    Update_VC_Object.Remark = f'Editted on {current_datetime()}'
                    Update_VC_Object.save()
                #Update objects order:
                Update_VC_list = DB_VC_list()
                code = '531'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], Update_VC_list, DB_VC_Valid_amount())
            elif int(input_id) not in VC_ID:
                code = '517'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], VC_list, DB_VC_Valid_amount())
            elif int(input_id) in VC_ID:
                #Edit object:
                Update_VC_Object = VerificationCodeDB.objects.get(id=input_id)
                Update_VC_Object.Status = input_edit_value
                Update_VC_Object.Remark = f'Editted on {current_datetime()}'
                Update_VC_Object.save()
                #Update objects order:
                Update_VC_list = DB_VC_list()
                code = '531'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], Update_VC_list, DB_VC_Valid_amount())
            else:
                code = '686'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], VC_list, DB_VC_Valid_amount())
        #Used code:
        elif isUsedCode == True:
            code = '520'
            ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], VC_list, DB_VC_Valid_amount())
        else:
            code = '686'
            ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], VC_list, DB_VC_Valid_amount())

        #Return:
        return render(request, 'Spotify_control_vercode.html',ret_dict)
        #hello anh Nhan, Diem ngiu anh ne ahihi liu liu

    # Value Error:
    except ValueError:
        code = '518'
        ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], VC_list, DB_VC_Valid_amount())
        return render(request, 'Spotify_control_vercode.html',ret_dict)
    # Others:
    except Exception as e:
        code = '999'
        ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], VC_list, DB_VC_Valid_amount())
        return render(request, 'Spotify_control_vercode.html',ret_dict)
    

########## ANCHOR: GenerateCode ##########
@login_required(login_url='/Spot-admin')
def GenerateCode(request):
    try:
        if request.method == 'POST':
            ### Input ###  
            #Data:
            rawdata        = VerificationCodeDB.objects.all().values()
            #Amount:
            gen_amount     = lib.VerificationCode.vc_quantity
            max_amount     = lib.VerificationCode.vc_quantity_max
            valid_amount   = 0
            #Others:
            VC_list        = DB_VC_list()
            ret_dict       = {}

            ### Functions ###  
            #Counting valid vercode:
            for data in rawdata:
                if data['Status'] == 'valid':
                    valid_amount += 1

            #Max ID:
            max_id = id_gen(mode_='max', list_=VerificationCodeDB.objects.all().values())

            #Counting offset:
            offset = max_amount - valid_amount

            #Generate:
            if (valid_amount < max_amount) and offset >= 10:
                for i in range(1, gen_amount + 1):
                    #id:
                    id = max_id + i 
                    vercode = lib.VerificationCode.generateVC()
                    DB_gencode(id, vercode, 'valid', f'Generated on {current_datetime()}')
                VC_update_list = DB_VC_list()
                ret_dict = {'status' : f'Generated {gen_amount} code successfully.' , 'table': VC_update_list, 'valid_amount' : DB_VC_Valid_amount(), 'datetime': current_datetime()}
            elif (valid_amount < max_amount) and offset < 10:
                for i in range(1, offset + 1):
                    #id:
                    id = max_id + i 
                    vercode = lib.VerificationCode.generateVC()
                    DB_gencode(id, vercode, 'valid', f'Generated on {current_datetime()}')
                VC_update_list = DB_VC_list()
                ret_dict = {'status' : f'Generated {offset} code successfully.' , 'table': VC_update_list, 'valid_amount' : DB_VC_Valid_amount(), 'datetime': current_datetime()}
            else:
                ret_dict = {'status' : 'Full slot on database.' , 'table': VC_list, 'valid_amount' : DB_VC_Valid_amount(), 'datetime': current_datetime()}
        # Return:
        return render(request, 'Spotify_control_vercode.html',ret_dict)
    
    # Others:
    except Exception as e:
        code = '999'
        ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['admin'], VC_list, DB_VC_Valid_amount())
        return render(request, 'Spotify_control_vercode.html',ret_dict)
    
    
########## ANCHOR: ExportReport ##########
@login_required(login_url='/Spot-admin')
def ExportReport(request):   
    if request.method == 'POST':
        ### Input ###
        mode = 'Customer_format' ### REPORT ###
        Sel_month         = request.POST.get('monthfilter_n')
        Sel_year          = request.POST.get('yearfilter_n')
        DB_M_rawdata      = MainDB.objects.all().values()
        DB_MA_rawdata     = MasterAccountDB.objects.all().values()
        fil_data          = []
        succeed_MA_list   = []
        succeed_Mem_list  = []
        succeed_VC_list   = []
        succeed_data_dict = {}
        ### Raw data handling ###
        for raw in DB_M_rawdata:
            if str(raw['Datetime'][3:5]) == str(Sel_month) and \
               str(raw['Datetime'][6:10]) == str(Sel_year):
                fil_data.append(raw)
                
        #length/data:  
        if Sel_month == 'All':  
            length = len(DB_M_rawdata)
            data   = DB_M_rawdata
        else:                   
            length = len(fil_data) 
            data   = fil_data
            
        ### Excel handling ###
        output    = BytesIO()
        workbook  = xlsxwriter.Workbook(output)
        worksheet = workbook.add_worksheet('Report')
        #Tittle:
        tittle_format = workbook.add_format({
            'bold':     True,
            'border':   6,
            'font_size':   20,
            'align':    'center',
            'valign':   'vcenter',
            'fg_color': '#D7E4BC',
        })
        worksheet.merge_range('A1:F2', 'Spotify Family Report', tittle_format)
        #Header: Customer's requirement template
        header_data = ['Email', 'Link invite', 'Address', 'Số account đã joined', 'Joined account email /\nVerification Code', 'Created date']
        header_format = workbook.add_format({'text_wrap': True,'bold': True,'border': 1, 'align': 'center','bg_color': '#5BC85B'})
        error_format = workbook.add_format({'bold': True, 
                                                'border': 1, 
                                                'font_color': 'red', 
                                                'text_wrap': True,
                                                'align':'center',
                                                'valign': 'vcenter', 
                                                'fg_color': '#FFFF00',})
        for col_num, x_data in enumerate(header_data):
            worksheet.write(2, col_num, x_data, header_format)
        #Data in excel:
        if data == []:
            worksheet.merge_range('A4:F7', 'Empty data. Please check again!\n(Maybe there is no user joined in this month)', error_format)
        elif DB_MA_rawdata == []:
            worksheet.merge_range('A4:F7', 'Master account database is empty. Please check again!\n(No Spotify master account on database)', error_format)
        #Customter's requirement format:
        elif mode == 'Customer_format':
            data_format = workbook.add_format({'text_wrap': True, 'border': 1, 'align':'center'})
            #Get Master accounts in succeed cases:
            for data_1 in data:
                if data_1['MasterAccout'] not in succeed_MA_list and \
                    data_1['isJoined'] == True:
                    succeed_MA_list.append(data_1['MasterAccout'])
            
            #Get export account family data:
            for succeed in succeed_MA_list:
                for data_2 in data:
                    if succeed == data_2['MasterAccout'] and \
                        data_2['isJoined'] == True:
                            succeed_Mem_list.append(data_2['Username'])
                            succeed_VC_list.append(data_2['VerCode'])
                            LinkJoin = data_2['FamLink'] 
                            Address  = data_2['Address'] 
                            #Get Created date:
                            try:
                                DB_MA_rawdata = MasterAccountDB.objects.get(Username=data_2['MasterAccout'])
                                Created_Date = DB_MA_rawdata.Date
                            except MasterAccountDB.MultipleObjectsReturned: 
                                DB_MA_rawdata = MasterAccountDB.objects.filter(Username=data_2['MasterAccout']).first()
                                Created_Date = DB_MA_rawdata.Date
                succeed_data_dict[succeed] = {
                    'MasterAccout' : succeed,
                    'Linkjoin'     : LinkJoin,
                    'Address'      : Address,
                    'MemNum'       : len(succeed_Mem_list),
                    'Vercode'      : succeed_VC_list.copy(),
                    'Username'     : succeed_Mem_list.copy(),
                    'Date'         : Created_Date
                }
                succeed_VC_list.clear()
                succeed_Mem_list.clear()
            
            l_length = len(succeed_MA_list)   
            for row in range(3, l_length+3):
                for column in range(len(header_data)):
                    MA = succeed_MA_list[row-3]
                    if   column == 0: worksheet.write(row, column, succeed_data_dict[MA]['MasterAccout']      , data_format)
                    elif column == 1: worksheet.write(row, column, succeed_data_dict[MA]['Linkjoin']          , data_format)
                    elif column == 2: worksheet.write(row, column, succeed_data_dict[MA]['Address']           , data_format)
                    elif column == 3: worksheet.write(row, column, succeed_data_dict[MA]['MemNum']            , data_format)
                    elif column == 4: 
                        string = ''
                        l_length_succeed_Mem = len(succeed_data_dict[MA]['Username'])
                        for ind in range(l_length_succeed_Mem):
                            string += f'''- Email: {succeed_data_dict[MA]['Username'][ind]} (VCode: {succeed_data_dict[MA]['Vercode'][ind]})\n'''
                        worksheet.write(row, column, string                                                   , data_format)
                    elif column == 5: worksheet.write(row, column, succeed_data_dict[MA]['Date']              , data_format)
                    else:
                        #For next release
                        pass

        #All cases (Both passed and failed)        
        elif mode == 'all':  
            data_format = workbook.add_format({'border': 1, 'align':'center'})
            for row in range(3,length+3):
                for column in range(len(header_data)):
                    if column == 0:   worksheet.write(row, column, data[row-3]['id']                                    , data_format)
                    elif column == 1: worksheet.write(row, column, data[row-3]['Username']                              , data_format)
                    elif column == 2: worksheet.write(row, column, data[row-3]['MasterAccout']                          , data_format)
                    elif column == 3: worksheet.write(row, column, data[row-3]['FamLink']                               , data_format)
                    elif column == 4: worksheet.write(row, column, data[row-3]['Address']                               , data_format)
                    elif column == 5: worksheet.write(row, column, data[row-3]['VerCode']                               , data_format)
                    elif column == 6: worksheet.write(row, column, 'Yes' if data[row-3]['isJoined'] == True else 'No'   , data_format)
                    elif column == 7: worksheet.write(row, column, data[row-3]['Detail']                                , data_format)
                    elif column == 8: worksheet.write(row, column, data[row-3]['Datetime']                              , data_format)
                    else:
                        #For next release
                        pass
        #Passed cases only (Customer requirememt)            
        else: 
            data_format = workbook.add_format({'border': 1, 'align':'center'})
            row = 3
            for id in range(3,length+3):
                if data[id-3]['isJoined'] == True: 
                    for column in range(len(header_data)):
                        if column == 0:   worksheet.write(row, column, data[id-3]['id']                                    , data_format)
                        elif column == 1: worksheet.write(row, column, data[id-3]['Username']                              , data_format)
                        elif column == 2: worksheet.write(row, column, data[id-3]['MasterAccout']                          , data_format)
                        elif column == 3: worksheet.write(row, column, data[id-3]['FamLink']                               , data_format)
                        elif column == 4: worksheet.write(row, column, data[id-3]['Address']                               , data_format)
                        elif column == 5: worksheet.write(row, column, data[id-3]['VerCode']                               , data_format)
                        elif column == 6: worksheet.write(row, column, 'Yes' if data[id-3]['isJoined'] == True else 'No'   , data_format)
                        elif column == 7: worksheet.write(row, column, data[id-3]['Detail']                                , data_format)
                        elif column == 8: worksheet.write(row, column, data[id-3]['Datetime']                              , data_format)
                        else:
                            #For next release
                            pass
                    #row increase:
                    row +=1
        worksheet.autofit()
        workbook.close()

        ### Reponse handling ###
        # create a response
        response = HttpResponse(content_type='application/vnd.ms-excel')
        # tell the browser what the file is named
        response['Content-Disposition'] = f'attachment;filename="SFReport_{current_datetime()}.xlsx"'
        # put the spreadsheet data into the response
        response.write(output.getvalue())
        # return the response
        return response


@login_required(login_url='/Spot-admin')
########## ANCHOR: EditData ##########
def EditData(request):   
    try:
        if request.method == 'POST':
            ### Input ###
            DB_M_rawdata       = MainDB.objects.all().values()
            DB_MA_rawdata      = MasterAccountDB.objects.all().values()
            #Edit info:
            MA_id              = request.POST.get('id')
            editted_email      = request.POST.get('email')
            editted_inviteLink = request.POST.get('inviteLink')
            editted_address    = request.POST.get('address')
            current_email      = ''
            #Others:
            isMAavailable      = False
            
            ### Methods ###
            #Edit MA info in MasterAccountDB:
            for MA in DB_MA_rawdata:
                if int(MA_id) == MA['id']:
                    isMAavailable   = True
                    #Current data:
                    current_email      = MA['Username']
                    #Edit data:
                    Update = MasterAccountDB.objects.get(id = MA_id)
                    Update.Username = editted_email
                    Update.FamLink  = editted_inviteLink
                    Update.Address  = editted_address
                    Update.save()
                    
                
            #Edit Account info in MainDB:
            if isMAavailable:
                for Account in DB_M_rawdata:
                    if Account['MasterAccout'] == current_email:
                        Update = MainDB.objects.get(id = Account['id'])
                        Update.MasterAccout = editted_email
                        Update.FamLink      = editted_inviteLink
                        Update.Address      = editted_address
                        Update.save()
                        
                code = '526'
                ret_dict = DB_M_succeed_table(code)
                return render(request, 'Spotify_control.html',ret_dict)
                    
            else:
                code = '525'
                ret_dict = DB_M_succeed_table(code)
                return render(request, 'Spotify_control.html',ret_dict)
            
    except:
        code = '999'
        ret_dict = DB_M_succeed_table(code)
        return render(request, 'Spotify_control.html',ret_dict)


@login_required(login_url='/Spot-admin')
########## ANCHOR: UploadData ##########
def UploadData(request):   
    if request.method == 'POST':
        try: 
            ### Input ###
            nation        = request.POST.get('nationsel_n')
            dataset       = Dataset()
            DB_MA_rawdata = MasterAccountDB.objects.all().values()
            data          = []
            MA_list       = []
            
            print(nation)
            #Import excel:
            excel_file = request.FILES['uploadData-name']
            import_data = dataset.load(excel_file.read(), format='xlsx')
            print(import_data)
            # Change "Dataset" to "List"
            for data_col in import_data:
                if data_col[4] not in [None, 'None', 'Date']:
                    data.append({'Username' : data_col[0], 
                                'FamLink'  : data_col[1], 
                                'Address'  : data_col[2], 
                                'MemNum'   : data_col[3], 
                                'Date'     : (data_col[4]).strftime(D_format)})
                    print('hihi')
                    
            #Master account list:
            for i in DB_MA_rawdata:
                MA_list.append(i['Username'])
                
            #Update on DB:
            for Master_acc in data:
                id  = id_gen(mode_= 'new', list_= MasterAccountDB.objects.all().values())
                if Master_acc['Username'] in MA_list:
                    code = '522'
                    ret_dict = DB_M_succeed_table(code)
                    return render(request, 'Spotify_control.html',ret_dict)
                elif Master_acc['Username'] not in ['Master Username', None]:
                    DB_upload(id,
                            Master_acc['Username'],  
                            Master_acc['FamLink'],
                            Master_acc['Address'],
                            nation,
                            Master_acc['MemNum'],
                            Master_acc['Date'])

            #Return:
            code = '524'
            ret_dict = DB_M_succeed_table(code)
            return render(request, 'Spotify_control.html',ret_dict)
        except Exception as error:
            code = '999'
            ret_dict = DB_M_succeed_table(code)
            return render(request, 'Spotify_control.html',ret_dict)
    else:
        code = '532'
        ret_dict = DB_M_succeed_table(code)
        return render(request, 'Spotify_control.html',ret_dict)
    
@login_required(login_url='/Spot-admin')
########## ANCHOR: UploadProxy ##########
def UploadProxy(request):   
    if request.method == 'POST':
        # try: 
            ### Input ###
            dataset          = Dataset()
            DB_Proxy_rawdata = ProxyManamentDB.objects.all().values()
            data             = []
            IP_list          = []
            
            #Import excel:
            excel_file   = request.FILES['uploadProxy-name']
            import_proxy = dataset.load(excel_file.read(), format='xlsx')
            
            
            # Change "Dataset" to "List"
            for data_col in import_proxy:
                if data_col[5] not in [None, 'None', 'Activated Date']:
                    data.append({'Protocol'      : data_col[0], 
                                 'IP'            : data_col[1], 
                                 'Proxy_User'    : data_col[2], 
                                 'Proxy_PW'      : data_col[3], 
                                 'Nation'        : data_col[4], 
                                 'ActivatedDate' : (data_col[5]).strftime(D_format)})
            #Master account list:
            for i in DB_Proxy_rawdata:
                IP_list.append(i['IP'])
            #Update on DB:
            for proxy in data:
                print(proxy)
                id = id_gen(mode_= 'new', list_= ProxyManamentDB.objects.all().values())
                if proxy['IP'] in IP_list:
                    code = '527'
                    ret_dict = DB_Proxy_table(code)
                    return render(request, 'Spotify_control_proxy.html',ret_dict)
                elif proxy['IP'] not in ['IP & Port', None]:
                    DB_Proxy_upload(id,
                            proxy['Protocol'],  
                            proxy['IP'],
                            proxy['Proxy_User'],
                            proxy['Proxy_PW'],
                            proxy['Nation'],
                            proxy['ActivatedDate'])

            #Return:
            code = '524'
            ret_dict = DB_Proxy_table(code)
            return render(request, 'Spotify_control_proxy.html',ret_dict)
        # except Exception as error:
        #     code = '999'
        #     ret_dict = DB_Proxy_table(code)
        #     return render(request, 'Spotify_control_proxy.html',ret_dict)
    else:
        code = '532'
        ret_dict = DB_Proxy_table(code)
        return render(request, 'Spotify_control_proxy.html',ret_dict)

def LogoutAdmin(request):   
    logout(request)
    return redirect('Administrator')

### OTHERS ###
def get_test(request):
    return render(request, 'test.html')

def get_test_rep(request):
    return HttpResponse('')

def get_login(request):
    return render(request, 'Spotify_login.html')

def SysCtrlSpotifyTab(request):
    code = '532'
    ret_dict = DB_M_succeed_table(code)
    return render(request, 'Spotify_control.html',ret_dict)

def VerificationTab(request): 
    ### Input ###  
    VC_list = DB_VC_list()
    ret_dict = {'table' : VC_list, 'valid_amount' : DB_VC_Valid_amount()}  
    return render(request, 'Spotify_control_vercode.html',ret_dict)

def ProxyManageTab(request): 
    ### Input ### 
    code = '532'
    ret_dict = DB_Proxy_table(code)
    return render(request, 'Spotify_control_proxy.html',ret_dict)
