// Program to check if a given
// string is valid IPv4 address or not
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "ip_validator.h"

/* function to check whether the 
   string passed is valid or not */
int valid_part(char *s)
{
    int n = strlen(s);

    // if length of passed string is
    // more than 3 then it is not valid
    if (n > 3)
        return 0;

    // check if the string only contains digits
    // if not then return 0
    for (int i = 0; i < n; i++)
        if ((s[i] >= '0' && s[i] <= '9') == 0)
            return 0;

    // if the string is "00" or "001" or
    // "05" etc then it is not valid
    // if (str.find('0') == 0 && n > 1)
    if (s[0] == '0' && n > 1)
        return 0;

    int x;
    sscanf(s, "%d", &x);

    // the string is valid if the number
    // generated is between 0 to 255
    return (x >= 0 && x <= 255);
}

/* return 1 if IP string is 
valid, else return 0 */
int is_valid_ip(char *ip_str)
{
    // if empty string then return 0
    if (ip_str == NULL)
        return 0;
    int i, num, dots = 0;
    int len = strlen(ip_str);
    int count = 0;

    // the number dots in the original
    // string should be 3
    // for it to be valid
    for (int i = 0; i < len; i++)
        if (ip_str[i] == '.')
            count++;
    if (count != 3)
        return 0;

    char *ptr = strtok(ip_str, DELIM);
    if (ptr == NULL)
        return 0;

    while (ptr)
    {
        /* after parsing string, it must be valid */
        if (valid_part(ptr))
        {
            /* parse remaining string */
            ptr = strtok(NULL, ".");
            if (ptr != NULL)
                ++dots;
        }
        else
            return 0;
    }

    /* valid IP string must contain 3 dots */
    // this is for the cases such as 1...1 where
    // originally the no. of dots is three but
    // after iteration of the string we find
    // it is not valid
    if (dots != 3)
        return 0;
    return 1;
}

// // Driver code
// int main()
// {
//     char ip1[] = "128.0.0.1";
//     char ip2[] = "125.16.100.1";
//     char ip3[] = "125.512.100.1";
//     char ip4[] = "125.512.100.abc";
//     printf("\n%s\n", is_valid_ip(ip1) ? "Valid\n" : "Not valid\n");
//     printf("\n%s\n", is_valid_ip(ip2) ? "Valid\n" : "Not valid\n");
//     printf("\n%s\n", is_valid_ip(ip3) ? "Valid\n" : "Not valid\n");
//     printf("\n%s\n", is_valid_ip(ip4) ? "Valid\n" : "Not valid\n");

//     return 0;
// }