import datetime
dt_string =  datetime.datetime.now()
day   = dt_string.day
month = dt_string.month
year  = dt_string.year
demo = {
            'Status'     : 'Success',
            'Username'   : 'free280223@kikyushop.com',
            'Premium_ID' : 'CzX87ZyAX178xbc',
            'Time'       : f'{day}/{month}/{year}'
            }
print(str(demo))