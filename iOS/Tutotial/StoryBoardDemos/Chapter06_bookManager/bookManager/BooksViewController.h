//
//  BooksViewController.h
//  bookManager
//
//  Created by Yulia McCarthy on 4/28/12.
//  Copyright (c) 2012 InspireSmart Solutions, Inc. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "DBCategory.h"
#import "DBAuthor.h"
#import "AddBookViewController.h"

@interface BooksViewController : UIViewController <AddBookVCDelegate>

@property (nonatomic, strong) DBCategory *category;
@property (nonatomic, strong) DBAuthor *author;

@end