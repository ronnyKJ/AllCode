//
//  AddBookViewController.h
//  bookManager
//
//  Created by Yulia McCarthy on 4/28/12.
//  Copyright (c) 2012 InspireSmart Solutions, Inc. All rights reserved.
//


#import <UIKit/UIKit.h>
#import "SelectionViewController.h"

@protocol AddBookVCDelegate;

@interface AddBookViewController : UITableViewController <UITextFieldDelegate, UITextViewDelegate, SelectionVCDelegate>

@property (nonatomic, assign) id<AddBookVCDelegate> delegate;
@end

@protocol AddBookVCDelegate <NSObject>
- (void)addBookVC:(AddBookViewController *)aVC didCreateObject:(id)anObject;
@end