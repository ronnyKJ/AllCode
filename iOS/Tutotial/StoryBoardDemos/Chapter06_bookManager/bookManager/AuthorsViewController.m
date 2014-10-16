//
//  AuthorsViewController.m
//  bookManager
//
//  Created by Yulia McCarthy on 4/28/12.
//  Copyright (c) 2012 InspireSmart Solutions, Inc. All rights reserved.
//

#import "AuthorsViewController.h"
#import "DBBook.h"
#import "BooksViewController.h"
#import "DetailViewController.h"
#import "CustomCell.h"

@interface AuthorsViewController () {
    NSMutableArray *_authors;
}
    
@property (weak, nonatomic) IBOutlet UITableView *_tableView;

@end

@implementation AuthorsViewController
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
    _authors = [NSMutableArray arrayWithArray:[DBAuthor allAuthors]];
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


#pragma mark - Table View

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{ 
    return _authors.count + 1;
}


- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    NSString *cellIdentifier = (indexPath.row < _authors.count) ? @"Cell" : @"AddCell";
    
    CustomCell *cell = [tableView dequeueReusableCellWithIdentifier:cellIdentifier];

    if ([cell.reuseIdentifier isEqualToString:@"Cell"]) {
        DBAuthor *object = [_authors objectAtIndex:indexPath.row];
        cell.mainLabel.text = object.fullName;
        cell.detailLabel2.text = [NSString stringWithFormat:@"%d", object.books.count];
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
        DBAuthor *object = [_authors objectAtIndex:indexPath.row];
        [object deleteEntity];
        [_authors removeObjectAtIndex:indexPath.row];
        [tableView deleteRowsAtIndexPaths:[NSArray arrayWithObject:indexPath] withRowAnimation:UITableViewRowAnimationFade];
    } else if (editingStyle == UITableViewCellEditingStyleInsert) {

    }
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath {
    
    UITableViewCell *cell = [tableView cellForRowAtIndexPath:indexPath];
    if ([cell.reuseIdentifier isEqualToString:@"Cell"]) {
        DBAuthor *object = [_authors objectAtIndex:indexPath.row];
        if (object.books.count > 1 || object.books.count == 0) {
            [self performSegueWithIdentifier:@"ShowAuthorBooks" sender:[tableView cellForRowAtIndexPath:indexPath]];
        }
        else if (object.books.count == 1) {
            [self performSegueWithIdentifier:@"ShowAuthorBookDetails" sender:[tableView cellForRowAtIndexPath:indexPath]];
        }
    }
    else {
        UIAlertView *alertView = [[UIAlertView alloc] initWithTitle:@"Add Author" message:nil delegate:self cancelButtonTitle:@"Cancel" otherButtonTitles:@"Add", nil];
        alertView.alertViewStyle = UIAlertViewStylePlainTextInput;
        UITextField *alertTextField = [alertView textFieldAtIndex:0];
        [alertTextField setPlaceholder:@"First Name"];
        [alertView show];
    }
}


#pragma mark - UIAlertViewDelegate Methods

- (void)alertView:(UIAlertView *)alertView didDismissWithButtonIndex:(NSInteger)buttonIndex {
    
    // Add author alertView
    if (buttonIndex == 1) { 
        NSString *categoryName = [[alertView textFieldAtIndex:0] text];
        NSMutableArray *words = [NSMutableArray arrayWithArray:[categoryName componentsSeparatedByString: @" "]];
        NSMutableDictionary *authorDict = [NSMutableDictionary dictionaryWithObject:[words objectAtIndex:0] forKey:@"firstName"];
        [words removeObjectAtIndex:0];
        [authorDict setObject:[words componentsJoinedByString:@" "] forKey:@"lastName"];
        
        DBAuthor *newAuthor = [DBAuthor createEntityWithDictionary:authorDict];
        [_authors insertObject:newAuthor atIndex:0];
        NSIndexPath *indexPath = [NSIndexPath indexPathForRow:0 inSection:0];
        [self._tableView insertRowsAtIndexPaths:[NSArray arrayWithObject:indexPath] withRowAnimation:UITableViewRowAnimationAutomatic];
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

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    if ([[segue identifier] isEqualToString:@"ShowAuthorBooks"]) {
        NSIndexPath *indexPath = [self._tableView indexPathForSelectedRow];
        DBAuthor *object = [_authors objectAtIndex:indexPath.row];
        [(BooksViewController *)[segue destinationViewController] setAuthor:object];
        [(BooksViewController *)[segue destinationViewController] setCategory:nil];
    }
    if ([[segue identifier] isEqualToString:@"ShowAuthorBookDetails"]) {
        NSIndexPath *indexPath = [self._tableView indexPathForSelectedRow];
        DBAuthor *object = [_authors objectAtIndex:indexPath.row];
        [(DetailViewController *)[segue destinationViewController] setDetailItem:[object.books objectAtIndex:0]];
    }
}

@end
