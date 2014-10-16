//
//  BooksViewController.m
//  bookManager
//
//  Created by Yulia McCarthy on 4/28/12.
//  Copyright (c) 2012 InspireSmart Solutions, Inc. All rights reserved.
//

#import "BooksViewController.h"
#import "DBBook.h"
#import "CustomCell.h"
#import "DetailViewController.h"


@interface BooksViewController () {
    NSMutableArray *_books;
}

@property (weak, nonatomic) IBOutlet UITableView *_tableView;
@property (weak, nonatomic) IBOutlet UILabel *_countLabel;
@end

@implementation BooksViewController
@synthesize _tableView;
@synthesize _countLabel;
@synthesize category;
@synthesize author;

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
    
    if (self.category != nil) {
        _books = [NSMutableArray arrayWithArray:self.category.books];
    }
    else if (self.author != nil) {
        _books = [NSMutableArray arrayWithArray:self.author.books];
    }
    else {
        _books = [NSMutableArray arrayWithArray:[DBBook allBooks]];
    }

    
}

- (void)viewDidUnload
{
    [self set_tableView:nil];
    [self set_countLabel:nil];
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
    NSString *postFix = @"books";
    if (_books.count < 2) {
        postFix = @"book";
    }
    self._countLabel.text = [NSString stringWithFormat:@"%d %@", _books.count, postFix];
    return _books.count + 1;
}


- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath {
    if (indexPath.row < _books.count) {
        return 87.0;
    }
    
    return 50.0;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    NSString *cellIdentifier = (indexPath.row < _books.count) ? @"Cell" : @"AddCell";

    CustomCell *cell = [tableView dequeueReusableCellWithIdentifier:cellIdentifier];
    
    if ([cell.reuseIdentifier isEqualToString:@"Cell"]) {
        DBBook *object = [_books objectAtIndex:indexPath.row];
        cell.mainLabel.text = object.title;
        cell.detailLabel1.text = object.author.fullName;
        cell.detailLabel2.text = object.year;
        cell.leftImageView.image = [UIImage imageNamed:[NSString stringWithFormat:@"%@.png", object.bookId]]; 
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
        DBBook *object = [_books objectAtIndex:indexPath.row];
        [object deleteEntity];
        [_books removeObjectAtIndex:indexPath.row];
        [tableView deleteRowsAtIndexPaths:[NSArray arrayWithObject:indexPath] withRowAnimation:UITableViewRowAnimationFade];
    } else if (editingStyle == UITableViewCellEditingStyleInsert) {
        // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view.
    }
}

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    if ([[segue identifier] isEqualToString:@"ShowBookDetails"]) {
        NSIndexPath *indexPath = [self._tableView indexPathForSelectedRow];
        DBBook *object = [_books objectAtIndex:indexPath.row];
        [(DetailViewController *)[segue destinationViewController] setDetailItem:object];
    }
    if ([[segue identifier] isEqualToString:@"AddNewBook"]) {
        UINavigationController *navigationVC = (UINavigationController *)[segue destinationViewController]; 
        AddBookViewController *addBookVC = (AddBookViewController *)navigationVC.topViewController;
        [addBookVC setDelegate:self];
    }
}


#pragma mark - AddBookVCDelegate

- (void)addBookVC:(AddBookViewController *)aVC didCreateObject:(id)anObject {
    if ((self.category != nil && ((DBBook *)anObject).category != self.category) ||
        (self.author != nil && ((DBBook *)anObject).author != self.author)) {
        return;
    }
    [_books insertObject:anObject atIndex:0];
    NSIndexPath *indexPath = [NSIndexPath indexPathForRow:0 inSection:0];
    [self._tableView insertRowsAtIndexPaths:[NSArray arrayWithObject:indexPath] withRowAnimation:UITableViewRowAnimationAutomatic];
}


- (IBAction)editPressed:(UIBarButtonItem *)sender {
    if (self._tableView.editing) {
        self._tableView.editing = NO;
        sender.title = @"Edit";
    }
    else {
        self._tableView.editing = YES;
        sender.title = @"Done";
    }
}

@end
