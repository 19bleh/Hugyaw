
#include <iostream>
#include <iomanip>
using namespace std;

int main() {
    double loan, interestRate;
    char repeat;
    
    do {
		// input
   		 cout << "Enter the amount of your loan: ";
    	cin >> loan;
		while (loan<=0){
			cout<< "Invalid Amount. Try Again."<< endl;
			cout << "Enter the amount of your loan: ";
    		cin >> loan;
		}
    
    	cout << "Enter the interest rate you want in percent: ";
   		cin >> interestRate;
		while (interestRate<=0){
		cout<< "Invalid Amount. Try Again."<< endl;
		cout << "Enter the amount of your loan: ";
    	cin >> interestRate;
		}
    
    	//conversion of interest rate into decimal
	    interestRate /= 100;
	    
		// formula for monthly payment 
		double monthlyPayment = loan / 20.00;
		// declaring variables
		double balance = loan;
		double totalInterest = 0.0;
		int months = 0;
	
		// HEADERS to make the data more organize
		cout << "\nMonth\tPayment\t\tInterest\tBalance\n";
    	cout << "\n";
	

		while (balance > 0){
	
			// formula for interest 	
			double interest = (interestRate / 12) * balance;
			// formula for remaining balance 
			double remaining = monthlyPayment - interest;
		
			//to prevent negative balance in the data
			if (remaining > balance){
			remaining = balance;
			monthlyPayment = remaining + interest;
			}
			// the remaining balance will be deducted to the current balance until the balance is 0
			balance -= remaining;
			// total interest formula
            totalInterest += interest;
            months++;
            
            // make the data more presentable
            cout <<" " << months << "\t" << fixed << setprecision(2) << monthlyPayment << "\t\t" << interest << "\t\t" << balance << "\n";
		}
	
		//calculate the annual interest
		double annualInterest = (totalInterest / months) * 12;
	
		// formula for simple annualized percentage
		double simplePercentage = (annualInterest / loan) * 100;

		// dispalying the total interest and the simple annualized percentage
		cout << " " << endl;
		cout << " " << endl;
   	 	cout << "TOTAL INTEREST: $" << totalInterest << endl;
    	cout << " " << endl;
    	cout << "SIMPLE ANNUALIZED PERCENTAGE: " << simplePercentage << "%.";
    	cout << " " << endl;
		cout << " " << endl;
	
		// let the user make another calculation
			cout << "Do you want to make another loan? (y/n): ";
		cin >> repeat;
	} while (repeat == 'y' || repeat == 'Y');

    return 0;
}
