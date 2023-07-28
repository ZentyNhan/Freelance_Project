from django.db import models

# Create your models here.

class TEST(models.Model):
    a = models.CharField(max_length=150)
    b = models.CharField(max_length=150)
    def __str__(self):
        return self.a
    
class MainDB(models.Model):
    #Attributes:
    Username     = models.CharField(max_length=200)
    Password     = models.CharField(max_length=200)
    MasterAccout = models.CharField(max_length=200)
    FamLink      = models.CharField(max_length=200)
    Address      = models.CharField(max_length=200)
    VerCode      = models.CharField(max_length=20)
    isJoined     = models.BooleanField()
    Detail       = models.CharField(max_length=200)
    Datetime     = models.CharField(max_length=200)
    
    #Methods:
    def __str__(self):
        return self.Username
    
class MasterAccountDB(models.Model):
    #Attributes:
    Username = models.CharField(max_length=200)
    FamLink  = models.CharField(max_length=200)
    Address  = models.CharField(max_length=200)
    Nation   = models.CharField(max_length=20)
    MemNum   = models.IntegerField()
    Date     = models.CharField(max_length=200)
    
    #Methods:
    def __str__(self):
        return self.Username
    
class VerificationCodeDB(models.Model):
    #Attributes:
    VerCode = models.CharField(max_length=20)
    Status  = models.CharField(max_length=20)
    Remark  = models.CharField(max_length=200)
    
    #Methods:
    def __str__(self):
        return self.VerCode
    
class ListAccountFamilyDB(models.Model):
    #Attributes:
    MasterAccount = models.CharField(max_length=20)
    FamLink       = models.CharField(max_length=200)
    Address       = models.CharField(max_length=200)
    JoinedNum     = models.IntegerField()
    JoinedAcc     = models.CharField(max_length=2000)
    Date          = models.CharField(max_length=50)
    
    #Methods:
    def __str__(self):
        return self.MasterAccount
    
class StoredDB(models.Model):
    #Attributes:
    ActiveNation = models.CharField(max_length=20)
    
    #Methods:
    def __str__(self):
        return self.ActiveNation
    
    
    
    
    



    