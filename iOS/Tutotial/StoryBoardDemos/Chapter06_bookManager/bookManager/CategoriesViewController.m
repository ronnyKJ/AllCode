//
//  CategoriesViewController.m
//  bookManager
//
//  Created by Yulia McCarthy on 4/28/12.
//  Copyright (c) 2012 InspireSmart Solutions, Inc. All rights reserved.
//

#import "CategoriesViewController.h"
#import "DetailViewController.h"
#import "DBCategory.h"
#import "BooksViewController.h"


@interface CategoriesViewController () {
    NSMutableArray *_categories;
}


@property (weak, nonatomic) IBOutlet UITableView *_tableView;
@end

@implementation CategoriesViewController
@synthesize _tableView;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    _categories = [NSMutableArray arrayWithArray:[DBCategory allCategories]];
}

- (void)viewDidUnload
{
    [self set_tableView:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

#pragma mark - Table View Data Source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return _categories.count + 2;
}



- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *cellIdentifier = nil;
    if (indexPath.row < _categories.count) {
        cellIdentifier = @"Cell";
    }
    else if (indexPath.row == _categories.count) {
        cellIdentifier = @"AllCell";
    }
    else {
        cellIdentifier = @"AddCell";
    }
    
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:cellIdentifier];
    
    if ([cell.reuseIdentifier isEqualToString:@"Cell"]) {
        DBCategory *object = [_categories objectAtIndex:indexPath.row];
        cell.textLabel.text = object.categoryName;
    }
    
    return cell;
}

- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Return NO if you do not want the specified item to be editable.
    return YES;
}

- (void)tableView:(UITableView *)tableView commitEditingStyle:(UITableViewCellEditingStyle)editingStyle forRowAtIndexPath:(NSIndexPath *)indexPath
{
    if (editingStyle == UITableViewCellEditingStyleDelete) {
        DBCategory *object = [_categories objectAtIndex:indexPath.row];
        [object deleteEntity];
        [_categories removeObjectAtIndex:indexPath.row];
        [tableView deleteRowsAtIndexPaths:[NSArray arrayWithObject:indexPath] withRowAnimation:UITableViewRowAnimationFade];
    } else if (editingStyle == UITableViewCellEditingStyleInsert) {
        // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view.
    }
}


#pragma mark - Table View Data Delegate

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    UITableViewCell *cell = [tableView cellForRowAtIndexPath:indexPath];
    
    if ([cell.reuseIdentifier isEqualToString:@"AddCell"]) {
        UIAlertView *alertView = [[UIAlertView alloc] initWithTitle:@"Add Category" message:nil delegate:self cancelButtonTitle:@"Cancel" otherButtonTitles:@"Add", nil];
        alertView.alertViewStyle = UIAlertViewStylePlainTextInput;
        UITextField *alertTextField = [alertView textFieldAtIndex:0];
        [alertTextField setPlaceholder:@"Category Name"];
        [alertView show];
    }
}


#pragma mark - UIAlertViewDelegate Methods

- (void)alertView:(UIAlertView *)alertView didDismissWithButtonIndex:(NSInteger)buttonIndex {
    
    // Add category alertView
    if (buttonIndex == 1) { 
        NSString *categoryName = [[alertView textFieldAtIndex:0] text];
        DBCategory *newCategory = [DBCategory createEntityWithDictionary:[NSDictionary dictionaryWithObject:categoryName forKey:@"categoryName"]];
        [_categories insertObject:newCategory atIndex:0];
        NSIndexPath *indexPath = [NSIndexPath indexPathForRow:0 inSection:0];
        [self._tableView insertRowsAtIndexPaths:[NSArray arrayWithObject:indexPath] withRowAnimation:UITableViewRowAnimationAutomatic];
    }
}

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    if ([[segue identifier] isEqualToString:@"ShowCategoryBooks"]) {
        NSIndexPath *indexPath = [self._tableView indexPathForSelectedRow];
        DBCategory *object = [_categories objectAtIndex:indexPath.row];
        [(BooksViewController *)[segue destinationViewController] setCategory:object];
        [(BooksViewController *)[segue destinationViewController] setAuthor:nil];
    }
    if ([[segue identifier] isEqualToString:@"ShowAllBooks"]) {
        [(BooksViewController *)[segue destinationViewController] setCategory:nil];
        [(BooksViewController *)[segue destinationViewController] setAuthor:nil];
    }
}

- (IBAction)editPressed:(id)sender {
    if (!self._tableView.editing) {
        self._tableView.editing = YES;
        ((UIBarButtonItem *)sender).title = @"Done";
    }
    else {
        self._tableView.editing = NO;
        ((UIBarButtonItem *)sender).title = @"Edit";
    }
}

@end
