# Generated by Django 4.2.2 on 2023-07-22 11:14

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('login', '0011_remove_masteraccountdb_nation'),
    ]

    operations = [
        migrations.AddField(
            model_name='masteraccountdb',
            name='Nation',
            field=models.CharField(default=123, max_length=20),
            preserve_default=False,
        ),
    ]
