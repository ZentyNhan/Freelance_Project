# Generated by Django 4.2.2 on 2023-06-22 19:31

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('login', '0002_maindb'),
    ]

    operations = [
        migrations.AddField(
            model_name='maindb',
            name='Date',
            field=models.CharField(default=None, max_length=200),
            preserve_default=False,
        ),
    ]
