//
//  DBAuthor.m
//  bookManager
//
//  Created by Yulia McCarthy on 4/26/12.
//  Copyright (c) 2012 InspireSmart Solutions, Inc. All rights reserved.
//

#import "DBAuthor.h"
#import "DBBook.h"

@implementation DBAuthor

@dynamic authorId;
@dynamic firstName;
@dynamic lastName;


+ (NSArray *)allAuthors {
    return [DBAuthor MR_findAllSortedBy:@"lastName" ascending:YES];
}

- (NSArray *)books {
    return [DBBook MR_findByAttribute:@"authorId" withValue:self.authorId]; 
}

- (NSString *)fullName {
    return [NSString stringWithFormat:@"%@ %@", self.firstName, self.lastName];
}

+ (DBAuthor *)createEntityWithDictionary:(NSDictionary *)aDictionary {
    // Get the local context
    NSManagedObjectContext *localContext = [NSManagedObjectContext MR_contextForCurrentThread];
    
    // Create a new Book in the local context
    DBAuthor *newEntity= [DBAuthor MR_createInContext:localContext];
    
    // Set the properties
    [newEntity setValuesForKeysWithDictionary:aDictionary];
    NSInteger passedId = [[aDictionary objectForKey:@"authorId"] intValue];
    if (passedId == 0) {
        NSInteger maxId = [[DBBook MR_aggregateOperation:@"max:" onAttribute:@"authorId" withPredicate:nil inContext:localContext] intValue];
        newEntity.authorId = [NSNumber numberWithInt:(maxId + 1)];
    }
    
    // Save the modification in the local context
    [localContext MR_save];
    
    return newEntity;
}

- (void)deleteEntity {
    // Get the local context
    NSManagedObjectContext *localContext = [NSManagedObjectContext MR_contextForCurrentThread];
    
    // Delete the book
    [self MR_deleteInContext:localContext];
    
    // Save the modification in the local context
    [localContext MR_save];
}
@end
