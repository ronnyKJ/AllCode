//
//  SelectionViewController.h
//  bookManager
//
//  Created by Yulia McCarthy on 4/28/12.
//  Copyright (c) 2012 InspireSmart Solutions, Inc. All rights reserved.
//


#import <UIKit/UIKit.h>

@protocol SelectionVCDelegate;

@interface SelectionViewController : UITableViewController

@property (nonatomic, strong) NSArray *objects;
@property (nonatomic, assign) id<SelectionVCDelegate> delegate;

@end

@protocol SelectionVCDelegate <NSObject>
- (void)selectionVC:(SelectionViewController *)aVC didSelectObject:(id)anObject;
@end