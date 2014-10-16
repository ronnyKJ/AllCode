//
//  DBBook.h
//  bookManager
//
//  Created by Yulia McCarthy on 4/26/12.
//  Copyright (c) 2012 InspireSmart Solutions, Inc. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <CoreData/CoreData.h>
#import "DBAuthor.h"
#import "DBCategory.h"

@interface DBBook : NSManagedObject

@property (nonatomic, retain) NSNumber * bookId;
@property (nonatomic, retain) NSNumber * categoryId;
@property (nonatomic, retain) NSNumber * authorId;
@property (nonatomic, retain) NSString * title;
@property (nonatomic, retain) NSString * year;
@property (nonatomic, retain) NSString * bookDescription;
@property (nonatomic, retain) NSString * imageName;

- (DBAuthor *)author;
- (DBCategory *)category;
+ (NSArray *)allBooks;
+ (NSArray *)allFavoriteBooks;
+ (DBBook *)createEntityWithDictionary:(NSDictionary *)aDictionary;
- (void)deleteEntity;
@end
