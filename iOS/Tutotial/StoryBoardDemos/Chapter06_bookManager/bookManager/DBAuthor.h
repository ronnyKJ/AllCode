//
//  DBAuthor.h
//  bookManager
//
//  Created by Yulia McCarthy on 4/26/12.
//  Copyright (c) 2012 InspireSmart Solutions, Inc. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <CoreData/CoreData.h>


@interface DBAuthor : NSManagedObject

@property (nonatomic, retain) NSNumber * authorId;
@property (nonatomic, retain) NSString * firstName;
@property (nonatomic, retain) NSString * lastName;

+ (NSArray *)allAuthors;
- (NSArray *)books;
- (NSString *)fullName;

+ (DBAuthor *)createEntityWithDictionary:(NSDictionary *)aDictionary;
- (void)deleteEntity;
@end
