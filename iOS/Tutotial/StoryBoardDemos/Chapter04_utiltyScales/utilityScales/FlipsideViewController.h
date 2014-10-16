//
//  FlipsideViewController.h
//  utilityScales
//
//  Created by Stephen Moraco on 12/06/01.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Scale.h"

@class FlipsideViewController;

@protocol FlipsideViewControllerDelegate
// report the selection from this view
- (void)flipsideViewController:(FlipsideViewController *)controller selectedScale:(Scale *)scale;

// report that the user is done with this view
- (void)flipsideViewControllerDidFinish:(FlipsideViewController *)controller;
@end

@interface FlipsideViewController : UIViewController<UITableViewDataSource, UITableViewDelegate> {
    
}


@property (weak, nonatomic) id <FlipsideViewControllerDelegate> delegate;
@property (readwrite, atomic) enum eScaleType selectedScaleType;
@property (weak, nonatomic) IBOutlet UITableView *tvScaleTable;

- (IBAction)done:(id)sender;

@end
