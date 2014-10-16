//
//  RootViewController.m
//  MSCDemo
//
//  Created by iflytek on 13-6-6.
//  Copyright (c) 2013年 iflytek. All rights reserved.
//

#import "RootViewController.h"
#import "ISRViewController.h"
#import <QuartzCore/QuartzCore.h>

#import "iflyMSC/IFlySpeechSynthesizerDelegate.h"
#import "iflyMSC/IFlySpeechRecognizer.h"
#import "iflyMSC/IFlySpeechSynthesizer.h"

@implementation RootViewController
- (id) init
{
    self = [super init];
    _functions = [[NSArray alloc]initWithObjects:@"语音转文本",nil];
    self.view.backgroundColor = [UIColor whiteColor];
    self.title = @"讯飞语音示例";
    //int top = Margin;
    
    //adjust the UI for iOS 7
    #if __IPHONE_OS_VERSION_MAX_ALLOWED >= 70000
     if ( IOS7_OR_LATER )
     {
         self.edgesForExtendedLayout = UIRectEdgeNone;
         self.extendedLayoutIncludesOpaqueBars = NO;
         self.modalPresentationCapturesStatusBarAppearance = NO;
         self.navigationController.navigationBar.translucent = NO;
     }
    #endif
    

    
    UITableView * tableView = [[UITableView alloc]initWithFrame:CGRectMake(0, Margin , self.view.frame.size.width, self.view.frame.size.height) style:UITableViewStyleGrouped];
    tableView.delegate = self;
    tableView.dataSource = self;
    
    [self.view addSubview:tableView];
    
    _popUpView = [[PopupView alloc]initWithFrame:CGRectMake(100, 300, 0, 0)];
    
    
    [tableView release];
    return self;
    
}

#pragma mark - Table view data source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return _functions.count;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *CellIdentifier = @"Cell";
    
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier];
    if (cell == nil) {
        cell = [[[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:CellIdentifier] autorelease];
    }
    
    cell.textLabel.text = [_functions objectAtIndex:indexPath.row];
    cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
    return cell ;
}

#pragma mark - Table view delegate

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
    switch (indexPath.row) {
        case 0:
        {
            ISRViewController * isr = [[ISRViewController alloc]init];
            [self.navigationController pushViewController:isr animated:YES];
            [isr release];
            break;
        }
        default:
            break;
    }
}

- (void)didReceiveMemoryWarning
{
    // Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
    
    // Release any cached data, images, etc that aren't in use.
}

#pragma mark - View lifecycle

/*
// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView
{
}
*/


// Implement viewDidLoad to do additional setup after loading the view, typically from a nib.
- (void)viewDidLoad
{
    [super viewDidLoad];
    NSString *initString = [[NSString alloc] initWithFormat:@"appid=%@",APPID];
    IFlySpeechSynthesizer  * _iFlySpeechSynthesizer = [[IFlySpeechSynthesizer createWithParams:initString delegate:self] retain];
    [_iFlySpeechSynthesizer startSpeaking:@"hello"];

}


-(void) dealloc
{
    [_popUpView release];
    [super dealloc];
}

- (void)viewDidUnload
{
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
    
    //[_functions release];
   // _functions = nil;
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}


@end
