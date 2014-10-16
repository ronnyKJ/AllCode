//
//  AddBookViewController.m
//  bookManager
//
//  Created by Yulia McCarthy on 4/28/12.
//  Copyright (c) 2012 InspireSmart Solutions, Inc. All rights reserved.
//

#import "AddBookViewController.h"
#import "DBBook.h"
#import "DBCategory.h"
#import "DBAuthor.h"

@interface AddBookViewController () {
    NSMutableDictionary *_bookDict;
}

@property (weak, nonatomic) IBOutlet UITextField *_titleTextField;
@property (weak, nonatomic) IBOutlet UITextField *_yearTextField;
@property (weak, nonatomic) IBOutlet UITextView *_descriptionTextView;

@end

@implementation AddBookViewController
@synthesize _titleTextField;
@synthesize _yearTextField;
@synthesize _descriptionTextView;
@synthesize delegate;

- (id)initWithStyle:(UITableViewStyle)style
{
    self = [super initWithStyle:style];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];

    // Uncomment the following line to preserve selection between presentations.
    // self.clearsSelectionOnViewWillAppear = NO;
 
    // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
    // self.navigationItem.rightBarButtonItem = self.editButtonItem;
}

- (void)viewDidUnload
{
    [self set_titleTextField:nil];
    [self set_yearTextField:nil];
    [self set_descriptionTextView:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}


#pragma mark - Text field delegate

- (void)textFieldDidEndEditing:(UITextField *)textField {
    if (textField.text.length == 0) {
        textField.text = @"";
    }
    if (_bookDict == nil) {
        _bookDict = [[NSMutableDictionary alloc] init];
    }
    
    if (textField == self._titleTextField) {
        [_bookDict setObject:textField.text forKey:@"title"];
    }
    if (textField == self._yearTextField) {
        [_bookDict setObject:textField.text forKey:@"year"];
    }
}

- (BOOL)textFieldShouldReturn:(UITextField *)textField {
    [textField resignFirstResponder];
    return YES;
}



#pragma mark - Text view delegate

- (void)textViewDidEndEditing:(UITextView *)textView {
    if (textView.text.length == 0) {
        textView.text = @"";
    }
    if (_bookDict == nil) {
        _bookDict = [[NSMutableDictionary alloc] init];
    }
    if (textView == self._descriptionTextView) {
        [_bookDict setObject:textView.text forKey:@"bookDescription"];
    }
}

- (BOOL)textViewShouldReturn:(UITextView *)textView {
    [textView resignFirstResponder];
    return YES;
}


- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    if ([[segue identifier] isEqualToString:@"SelectCategory"]) {
        [(SelectionViewController *)[segue destinationViewController] setObjects:[DBCategory allCategories]];
        [(SelectionViewController *)[segue destinationViewController] setDelegate:self];
    }
    if ([[segue identifier] isEqualToString:@"SelectAuthor"]) {
        [(SelectionViewController *)[segue destinationViewController] setObjects:[DBAuthor allAuthors]];
        [(SelectionViewController *)[segue destinationViewController] setDelegate:self];
    }
}


#pragma mark - SelectionVCDelegate

- (void)selectionVC:(SelectionViewController *)aVC didSelectObject:(id)anObject {
    if ([anObject isKindOfClass:[DBCategory class]]) {
        [_bookDict setObject:((DBCategory *)anObject).categoryId forKey:@"categoryId"];
        UITableViewCell *cell = [self.tableView cellForRowAtIndexPath:[NSIndexPath indexPathForRow:0 inSection:1]];
        cell.textLabel.text = ((DBCategory *)anObject).categoryName;
     }
    if ([anObject isKindOfClass:[DBAuthor class]]) {
        [_bookDict setObject:((DBAuthor *)anObject).authorId forKey:@"authorId"];
        UITableViewCell *cell = [self.tableView cellForRowAtIndexPath:[NSIndexPath indexPathForRow:0 inSection:2]];
        cell.textLabel.text = ((DBAuthor *)anObject).fullName;

    }
    [self.navigationController popViewControllerAnimated:YES];
}


- (IBAction)cancelPressed:(id)sender {
    [self dismissModalViewControllerAnimated:YES];
}


- (IBAction)savePressed:(id)sender {
    
    [self._titleTextField resignFirstResponder];
    [self._yearTextField resignFirstResponder];
    [self._descriptionTextView resignFirstResponder];
    
    // Create entities
    if (_bookDict != nil) {
        DBBook *newBoook = [DBBook createEntityWithDictionary:_bookDict];
        if ([self.delegate respondsToSelector:@selector(addBookVC:didCreateObject:)]) {
            [self.delegate addBookVC:self didCreateObject:newBoook];
        }
    }
    [self dismissModalViewControllerAnimated:YES];
}

@end
