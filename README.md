# Search_Web_Page

#This is a school project of creating a webpage with a search function. The oracle database is on the school server.
#step1: login the server: ssh h_w85@newfirebird.cs.txstate.edu 
#step2: upload source code and data file(expdat.dmp), use sqlplus H_W/PASS@CSDBORA to check if data is available
#step3: To get the sampe3 as example form: " cp "$ORACLE_HOME"/precomp/demo/proc MYPATH
#step 4: Modify the database login info in the sample3
#step 5: Compile the sample3 file: make -f demo_proc64.mk sample3 , use ./sample to test if the result is correct
#step 6: Follow the below steps and config the program.


Your_linux_login_name is your department Linux account login name, such as jc1002
$HOME is your home directory. For student jc1002, his/her home directory
should be /home/Students/jc1002 -- i.e $HOME=/home/Students/jc1002

0. If you don't have much idea for environemnt of Linux/Unix, download the file
   http://newfirebird.cs.txstate.edu/~wp01/.bashrc and save it as it is in your home
   directory. That file will set proper environment needed to run the class demos.

1. Download the file proc-demo.tar from: http://newfirebird.cs.txstate.edu/~wp01/proc-demo.tar

2. Download the file proc-cgi.tar from: http://newfirebird.cs.txstate.edu/~wp01/proc-cgi.tar

3. Download the file expdat.dmp from: http://newfirebird.cs.txstate.edu/~wp01/expdat.dmp

4. Go to the "public_html" subdirectory within your home directory, and move all three files
   that your downloaded in step 1-3 to this directory. Then perform the following
   operations:


   (1) tar xpf proc-demo.tar
   
       This operation should "untar" the proc.tar file. As a consequence it will 
       create a subdirectory named "demo" within your "public_html" directory,
       and create several subdirectories within the "demo" directory.

   (2) tar xpf proc-cgi.tar

       This operation should "untar" the proc-cgi.tar file -- it should create the
       subdirectory "cgi-bin" within "public_html" directory and place three files
       named "common.cgi", "home.pl", and "jobsearch.pl" within the directory
       "cgi-bin".

   (3) Issue the command
 
       imp your_oracle_account_name/your_oracle_account_password@csdbora

       This will import data from a previously dumped Oracle data file. Please
       follow the prompts step by step, and pay attention to the options provided
       at each step and answer all them with default values, except the
       question: "Import entire export file (yes/no): ". You should answer yes for
       that questin.

       If this operation is successful, it should create four tables named
       "job", "member", "c_g", and "job_ids" within your Oracle account (i.e.
       within your schema). These four tables are defined as follows:

       (a) The 'job' table:

	 Name                                    Null?    Type
	 --------------------------------------- -------- -------------------

	 JOB_ID                                  NOT NULL VARCHAR2(10)
	 JOB_TYPE                                         VARCHAR2(40)
	 JOB_TITLE                                        VARCHAR2(50)
	 SPECIALIZATION                                   VARCHAR2(50)
	 COUNTRY_CODE                                     NUMBER(3)
	 REGION_NAME                                      VARCHAR2(30)
	 STATE_NAME                                       VARCHAR2(20)
	 LOCATION                                         VARCHAR2(30)
	 MIN_SALARY                                       NUMBER(9)
	 MAX_SALARY                                       NUMBER(9)
	 COMPANY_NAME                                     VARCHAR2(50)
	 START_DATE                                       VARCHAR2(20)
	 REFERENCE_NUM                                    VARCHAR2(10)
	 CONTACT_PERSON                                   VARCHAR2(50)
	 DESCRIPTION                                      VARCHAR2(4000)
	 QUALIFICATION                                    VARCHAR2(2000)

       (b) The 'member' table:
	 Name                                 Null?    Type
	 ------------------------------------ -------- ----------------------------

	 LOGIN_ID                             NOT NULL VARCHAR2(20)
	 FIRST_NAME                           NOT NULL VARCHAR2(20)
	 MID_I_NAME                                    VARCHAR2(20)
	 LAST_NAME                            NOT NULL VARCHAR2(20)
	 SPECIALIZATION                       NOT NULL VARCHAR2(50)
	 EMAIL                                NOT NULL VARCHAR2(50)
	 PHONE                                         VARCHAR2(20)
	 FAX                                           VARCHAR2(20)
	 WEB_URL                                       VARCHAR2(50)
	 CURRENT_COMPANY                               VARCHAR2(30)
	 CURRENT_JOB_TITLE                    NOT NULL VARCHAR2(50)
	 CURRENT_JOB_LOCATION                 NOT NULL VARCHAR2(30)
	 CURRENT_JOB_LOCATION_CODE            NOT NULL NUMBER(1)
	 YEAR_OF_EXP                          NOT NULL NUMBER(2)
	 DEGREE                               NOT NULL NUMBER(1)
	 DESIRED_JOB_1                                 VARCHAR2(50)
	 DESIRED_JOB_2                                 VARCHAR2(50)
	 DESIRED_JOB_3                                 VARCHAR2(50)
	 DESIRED_SALARY                                NUMBER(9)
	 DESIRED_JOB_LOCATION                          VARCHAR2(30)
	 DESIRED_JOB_LOCATION_CODE                     NUMBER(1)
	 SPECIAL_TALENTS                               VARCHAR2(50)
	 RESUME                                   VARCHAR2(4000)

       (c) The 'c_g' table:
	 Name                                 Null?    Type
	 ------------------------------------ -------- -------------------

	 LOGIN_ID                             NOT NULL VARCHAR2(20)
	 FIRST_NAME                           NOT NULL VARCHAR2(20)
	 MID_I_NAME                                    VARCHAR2(20)
	 LAST_NAME                            NOT NULL VARCHAR2(20)
	 MAJOR                                NOT NULL VARCHAR2(50)
	 EMAIL                                NOT NULL VARCHAR2(50)
	 PHONE                                         VARCHAR2(20)
	 FAX                                           VARCHAR2(20)
	 WEB_URL                                       VARCHAR2(50)
	 COLLEGE_NAME                         NOT NULL VARCHAR2(30)
	 COLLEGE_CITY                                  VARCHAR2(30)
	 COLLEGE_STATE                                 VARCHAR2(30)
	 EXPECTED_DEGREE                      NOT NULL NUMBER(1)
	 EXPECTED_DEGREE_DATE                 NOT NULL DATE
	 EXPECTED_MIN_SALARY                           NUMBER(9)
	 DESIRED_JOB_LOCATION                          VARCHAR2(30)
	 DESIRED_JOB_LOCATION_CODE                     NUMBER(1)
	 SPECIAL_TALENTS                               VARCHAR2(50)
	 RESUME                                        VARCHAR2(4000)

       (d) The 'employer' table:

	 Name                                 Null?    Type
	 ------------------------------------ -------- ---------------

	 EMP_ID                               NOT NULL VARCHAR2(20)
	 COMPANY_NAME                         NOT NULL VARCHAR2(50)
	 CONTACT_PERSON                                VARCHAR2(50)
	 EMAIL                                         VARCHAR2(50)
	 PHONE                                         VARCHAR2(15)
	 FAX                                           VARCHAR2(15)
	 PROFILE                                       VARCHAR2(4000)
	 PASSWORD                                      VARCHAR2(20)

       (e) The 'job_ids' table:

	 Name                                 Null?    Type
	 --------------------------------------------- ----------

	 JOB_ID                                        NUMBER(9)

   You can bypass this step of importing my table contents by creating these
   tables according to above definition and then insert your own tuples into
   the four tables your created. In fact you are encouraged to do so.

5. Go to the subdirectory $HOME/public_html/demo/proc/unix-version/c++ and edit
   the file "local_const.h" as follows. Locating the entry for constant
   ORACLE_CREDENTIAL. Change them to your Oracle login name and password.
   The initial value for the constant is:

   #define ORACLE_CREDENTIAL "your_oracle_account_username/your_oracle_account_password@csdbora"

   You should change the "your_oracle_account_username" to your Oracle account name (not your Linux
   account name!) and "your_oracle_account_passwd" to your Oracle account password.

   
   Samilarly, edit the file "demo_proc64.mk" by changing the two substrings
   "your_oracle_username/your_oracle_passwd@csdbora" by providing your real oracle username and password.

6. Go to the directory $HOME/public_html/demo/proc/unix-version/html 
   For each html file in this directory, change each substring "/~wp01/..." to 
   "/~your_linux_login_name/..."

7. Go to the directory $HOME/cgi-bin
   For each perl file in this directory, change each substring "/home/Faculty/wp01/..."
   to "/home/Students/your_linux_login_name/..."

   It is very important for you to make the changes as described in step 6-8.
   Otherwise your program may appear working perfect. But it may actually invoke
   cgi and executables in my directories, not yours!

8. Compile:

   Compile the ematch_job.pc file:

       make -f demo_proc64.mk ematch_job

   If you add your own application files, you have to modify the file
   demo_proc64.mk accordingly.

9. If the compilation and setup are successful, you should be able to
   invoke the home page of the demonstration program using the URI:

      http://newfirebird.cs.txstate.edu/~your_login_name/demo/proc/unix-version/html/index.html


/******* problems conclusion *******/
1. To change the access limitation: chmod 777 filename 
2. php to exec("export LIB_PAT". )
