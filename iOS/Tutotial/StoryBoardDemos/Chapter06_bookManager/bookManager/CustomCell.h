//
//  CustomCell.h
//  bookManager
//
//  Created by Yulia McCarthy on 4/27/12.
//  Copyright (c) 2012 InspireSmart Solutions, Inc. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface CustomCell : UITableViewCell

@property (nonatomic, strong) IBOutlet UIImageView *leftImageView;
@property (nonatomic, strong) IBOutlet UILabel *mainLabel;
@property (nonatomic, strong) IBOutlet UILabel *detailLabel1;
@property (nonatomic, strong) IBOutlet UILabel *detailLabel2;

@end
