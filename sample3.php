
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <sqlca.h>

#define NAME_LENGTH    10
#define ARRAY_LENGTH   20

/* Another way to connect. */
char *username = "H_W85";
char *password = "WH890619";
char *db_string = "csdbora";

/* Declare a host structure tag. */
struct
{
    char    emp_name[ARRAY_LENGTH][NAME_LENGTH];
    float   salary[ARRAY_LENGTH];
    float   comm[ARRAY_LENGTH];
} emp_rec;

struct
{
    char    dept_name[ARRAY_LENGTH][NAME_LENGTH];
    char    emp_name[ARRAY_LENGTH][NAME_LENGTH];
    float   salary[ARRAY_LENGTH];
} emp_rec1;

void print_rows(n)
    int n;
{
    int i;

    printf("\nEmployee Name  Salary  Commission");
    printf("\n-------------  ------  -----------\n");

    for (i = 0; i < n; i++)
        printf("%s    %8.2f  %8.2f\n", emp_rec.emp_name[i],
               emp_rec.salary[i], emp_rec.comm[i]);

}

void print_rows1(n)
    int n;
{
    int i;

    printf("\nDeptName   Employee  Salary");
    printf("\n---------  --------  -------\n");

    for (i = 0; i < n; i++)
        printf("%s    %s  %8.2f\n", emp_rec1.dept_name[i],
               emp_rec1.emp_name[i], emp_rec1.salary[i]);

}

void sql_error(msg)
    char *msg;
{
    EXEC SQL WHENEVER SQLERROR CONTINUE;

    printf("\n%s", msg);
    printf("\n% .70s \n", sqlca.sqlerrm.sqlerrmc);

    EXEC SQL ROLLBACK WORK RELEASE;
exit(EXIT_FAILURE);
}

void main(int argc, char *argv[])
{
    int  num_ret;               /* number of rows returned */
    int deptno;
    char *dname = NULL;
    int salLow;
    int salHigh;
    int comLow;
    int comHigh;

/* Connect to ORACLE. */
    EXEC SQL WHENEVER SQLERROR DO sql_error("Connect error:");

    EXEC SQL CONNECT :username IDENTIFIED BY :password using :db_string;
    printf("\nConnected to ORACLE as user: %s using %s\n", username, db_string);


    EXEC SQL WHENEVER SQLERROR DO sql_error("Oracle error:");
/* Declare a cursor for the Problem 1. */
    if(strcmp(argv[1],"departmentNumber") == 0){
        deptno =atoi(argv[2]);
        EXEC SQL DECLARE c1 CURSOR FOR
        SELECT ename, sal, comm FROM emp WHERE deptno = :deptno;
        EXEC SQL OPEN c1;
        /* Initialize the number of rows. */
        num_ret = 0;
        /* Array fetch loop - ends when NOT FOUND becomes true. */
        EXEC SQL WHENEVER NOT FOUND DO break;
        for (;;)
        {
            EXEC SQL FETCH c1 INTO :emp_rec;
        /* Print however many rows were returned. */
            print_rows(sqlca.sqlerrd[2] - num_ret);
            num_ret = sqlca.sqlerrd[2];        /* Reset the number. */
        }
        /* Print remaining rows from last fetch, if any. */
        if ((sqlca.sqlerrd[2] - num_ret) > 0)
            print_rows(sqlca.sqlerrd[2] - num_ret);
        EXEC SQL CLOSE c1;

    }
    else if(strcmp(argv[1],"departmentName") == 0){
        dname = argv[2];
        EXEC SQL DECLARE c2 CURSOR FOR
        SELECT ename, sal, comm FROM emp WHERE emp.deptno = (SELECT deptno FROM dept WHERE dname = :dname);
        EXEC SQL OPEN c2;
        /* Initialize the number of rows. */
        num_ret = 0;
        /* Array fetch loop - ends when NOT FOUND becomes true. */
        EXEC SQL WHENEVER NOT FOUND DO break;
        for (;;)
        {
            EXEC SQL FETCH c2 INTO :emp_rec;
        /* Print however many rows were returned. */
            print_rows(sqlca.sqlerrd[2] - num_ret);
            num_ret = sqlca.sqlerrd[2];        /* Reset the number. */
        }
        /* Print remaining rows from last fetch, if any. */
        if ((sqlca.sqlerrd[2] - num_ret) > 0)
            print_rows(sqlca.sqlerrd[2] - num_ret);
        EXEC SQL CLOSE c2;
    }
/* Declare a cursor for the Problem 2. */
    else if(strcmp(argv[1],"salaryLow") == 0){
        salLow = atoi(argv[2]);
        salHigh = atoi(argv[3]);
        EXEC SQL DECLARE c3 CURSOR FOR
        SELECT d.dname, e.ename, e.sal FROM emp e, dept d WHERE e.sal >= :salLow AND e.sal <= :salHigh;
        EXEC SQL OPEN c3;
        /* Initialize the number of rows. */
        num_ret = 0;
        /* Array fetch loop - ends when NOT FOUND becomes true. */
        EXEC SQL WHENEVER NOT FOUND DO break;
        for (;;)
        {
            EXEC SQL FETCH c3 INTO :emp_rec1;
        /* Print however many rows were returned. */
            print_rows1(sqlca.sqlerrd[2] - num_ret);
            num_ret = sqlca.sqlerrd[2];        /* Reset the number. */
        }
        /* Print remaining rows from last fetch, if any. */
        if ((sqlca.sqlerrd[2] - num_ret) > 0)
            print_rows1(sqlca.sqlerrd[2] - num_ret);
        EXEC SQL CLOSE c3;
    }
/* Declare a cursor for the Problem 3. */
    else if(strcmp(argv[1],"commissionLow") == 0){
        comLow = atoi(argv[2]);
        comHigh = atoi(argv[3]);
        EXEC SQL DECLARE c4 CURSOR FOR
        SELECT d.dname, e.ename, e.sal FROM emp e, dept d WHERE e.comm >= :comLow AND e.comm <= :comHigh;
        EXEC SQL OPEN c4;
        /* Initialize the number of rows. */
        num_ret = 0;
        /* Array fetch loop - ends when NOT FOUND becomes true. */
        EXEC SQL WHENEVER NOT FOUND DO break;
        for (;;)
        {
            EXEC SQL FETCH c4 INTO :emp_rec1;
        /* Print however many rows were returned. */
            print_rows1(sqlca.sqlerrd[2] - num_ret);
            num_ret = sqlca.sqlerrd[2];        /* Reset the number. */
        }
        /* Print remaining rows from last fetch, if any. */
        if ((sqlca.sqlerrd[2] - num_ret) > 0)
            print_rows1(sqlca.sqlerrd[2] - num_ret);
        EXEC SQL CLOSE c4;
    }
/* Disconnect from the database. */
    EXEC SQL COMMIT WORK RELEASE;
    exit(EXIT_SUCCESS);
}
