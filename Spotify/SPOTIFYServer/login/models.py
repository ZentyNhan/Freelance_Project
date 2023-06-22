from django.db import models

# Create your models here.

class TEST(models.Model):
    a = models.CharField(max_length=150)
    b = models.CharField(max_length=150)
    def __str__(self):
        return self.a
    
class MainDB(models.Model):
    #Attributes:
    Username = models.CharField(max_length=200)
    Password = models.CharField(max_length=200)
    FamLink  = models.CharField(max_length=200)
    Address  = models.CharField(max_length=200)
    isJoined = models.BooleanField()
    Detail   = models.CharField(max_length=200)
    Date     = models.CharField(max_length=200)
    
    #Method
    def __str__(self):
        return self.Username


    