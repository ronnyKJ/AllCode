//
//  DBCategory.h
//  bookManager
//
//  Created by Yulia McCarthy on 4/26/12.
//  Copyright (c) 2012 InspireSmart Solutions, Inc. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <CoreData/CoreData.h>


@interface DBCategory : NSManagedObject

@property (nonatomic, retain) NSNumber * categoryId;
@property (nonatomic, retain) NSString * categoryName;

+ (NSArray *)allCategories;
- (NSArray *)books;

+ (DBCategory *)createEntityWithDictionary:(NSDictionary *)aDictionary;
- (void)deleteEntity;
@end
