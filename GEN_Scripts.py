try: #STUB CASE ['4_17_2']
	TC_Name = 'TESTCASE_4_17_2_EDIT_APPROVED_AF_PRODUCT_CLASS_BY_SUPER_ADMIN'
	Help_Function_INSTANCE.START_TC(TC_Name)
	Test_Execute.TESTCASE_4_17_2_EDIT_APPROVED_AF_PRODUCT_CLASS_BY_SUPER_ADMIN()
	Status_TC.append(Help_Function_INSTANCE.END_TC(TC_Name,'PASSED'))
except NoSuchElementException:
	Status_TC.append(Help_Function_INSTANCE.END_TC(TC_Name,'FAILED_ELEMENT_NOT_AVAILABLE'))
except AttributeError:
	Status_TC.append(Help_Function_INSTANCE.END_TC(TC_Name,'FAILED_TESTCASE_NOT_AVAILABLE'))

try: #STUB CASE ['4_18_2']
	TC_Name = 'TESTCASE_4_18_2_EDIT_APPROVED_AF_PRODUCT_CLASS_BY_MASTER'
	Help_Function_INSTANCE.START_TC(TC_Name)
	Test_Execute.TESTCASE_4_18_2_EDIT_APPROVED_AF_PRODUCT_CLASS_BY_MASTER()
	Status_TC.append(Help_Function_INSTANCE.END_TC(TC_Name,'PASSED'))
except NoSuchElementException:
	Status_TC.append(Help_Function_INSTANCE.END_TC(TC_Name,'FAILED_ELEMENT_NOT_AVAILABLE'))
except AttributeError:
	Status_TC.append(Help_Function_INSTANCE.END_TC(TC_Name,'FAILED_TESTCASE_NOT_AVAILABLE'))

