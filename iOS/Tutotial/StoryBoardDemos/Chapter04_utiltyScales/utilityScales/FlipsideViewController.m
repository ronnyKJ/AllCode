//
//  FlipsideViewController.m
//  utilityScales
//
//  Created by Stephen Moraco on 12/06/01.
//  Copyright (c) 2012 Iron Sheep Productions, LLC. All rights reserved.
//

#import "FlipsideViewController.h"

@interface FlipsideViewController () {
@private
    NSMutableArray *m_scScaleAr;
}

-(Scale *)selectedScaleForType:(enum eScaleType)eValue;

@end

@implementation FlipsideViewController

@synthesize delegate = _delegate;
@synthesize tvScaleTable = _tvScaleTable;
@synthesize selectedScaleType;

- (void)awakeFromNib
{
    self.contentSizeForViewInPopover = CGSizeMake(320.0, 480.0);
    [super awakeFromNib];
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
    
    if(m_scScaleAr == nil)
    {
        // pre-populate our list of scales (with detail info for each scale)
        m_scScaleAr = [[NSMutableArray alloc] init];
        
        // setup scale 1 of 8
        Scale *newScale = [[Scale alloc] initWithTitle:@"Rock & Country" 
                                           description:@"Major Pentatonic – 1st mode" 
                                                  type:ST_MAJOR_PENTATONIC_1ST_MODE 
                                         audioFileBase:@"01 Major Pentatonic 1st mode" 
                                         imageBasename:@"01 Major Pentatonic, 1st mode"];
        [m_scScaleAr addObject:newScale];
        
        // setup scale 2 of 8
        newScale = [[Scale alloc] initWithTitle:@"Rock & Country" 
                                    description:@"Major Pentatonic – 2nd mode" 
                                           type:ST_MAJOR_PENTATONIC_2ND_MODE 
                                  audioFileBase:@"02 Major Pentatonic 2nd mode" 
                                  imageBasename:@"02 Major Pentatonic, 2nd mode"];
        [m_scScaleAr addObject:newScale];
        
        // setup scale 3 of 8
        newScale = [[Scale alloc] initWithTitle:@"Folk" 
                                    description:@"Mixolydian" 
                                           type:ST_MIXOLYDIAN 
                                  audioFileBase:@"03 Mixolydian 5th mode" 
                                  imageBasename:@"03 Mixolydian"];
        [m_scScaleAr addObject:newScale];
        
        // setup scale 4 of 8
        newScale = [[Scale alloc] initWithTitle:@"Country Blues" 
                                    description:@"Minor Pentatonic, 5th mode of major" 
                                           type:ST_MINOR_PENTATONIC_5TH_MODE_OF_MAJOR 
                                  audioFileBase:@"04 Minor Pentatonic 5th mode of Major" 
                                  imageBasename:@"04 Minor Pentatonic, 5th of major"];
        [m_scScaleAr addObject:newScale];
        
        // setup scale 5 of 8
        newScale = [[Scale alloc] initWithTitle:@"Country Blues" 
                                    description:@"Blues Minor Hexatonic" 
                                           type:ST_BLUES_MINOR_HEXATONIC 
                                  audioFileBase:@"05 Blues Minor Hexatonic Minor Pentatonic dim 5" 
                                  imageBasename:@"05 Blues Minor Hexatonic"];
        [m_scScaleAr addObject:newScale];
        
        // setup scale 6 of 8
        newScale = [[Scale alloc] initWithTitle:@"Jazz" 
                                    description:@"Dominant Bebop (adds the raised 7th to Mixolydian)" 
                                           type:ST_DOMINANT_BEBOP 
                                  audioFileBase:@"06 Dominant Bebop raisd 7th to Mixolydian" 
                                  imageBasename:@"06 Dominant bebop"];
        [m_scScaleAr addObject:newScale];
        
        // setup scale 7 of 8
        newScale = [[Scale alloc] initWithTitle:@"Metal" 
                                    description:@"Aelioan – Phrygrian" 
                                           type:ST_AELIOAN 
                                  audioFileBase:@"07 Aelian and Phtygian" 
                                  imageBasename:@"07 Aeolian"];
        [m_scScaleAr addObject:newScale];
        
        // setup scale 8 of 8
        newScale = [[Scale alloc] initWithTitle:@"Spanish" 
                                    description:@"Phrygian Dominant" 
                                           type:ST_PHRYGIAN_DOMINANT 
                                  audioFileBase:@"08 Phrygian Dominant" 
                                  imageBasename:@"08 Phrygian"];
        [m_scScaleAr addObject:newScale];
    }
    
}

-(void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];     
  
	// determine which initial selection to show
    NSInteger nSelectedRowIdx = 0;
    
    // if selection is not yet made, select the first...
    if(self.selectedScaleType == ST_UNKNOWN)
    {
        // select our type from first in list
        NSInteger nFirstRow = 0;
        Scale *pFirstScale = [m_scScaleAr objectAtIndex:nFirstRow];
        self.selectedScaleType = pFirstScale.type;
        nSelectedRowIdx = nFirstRow;
    }
    else
    {
        // else main view want's to show latest selection...
        for (NSInteger nRowIdx=0; nRowIdx < [m_scScaleAr count]; nRowIdx++) {
            Scale *currScale = [m_scScaleAr objectAtIndex:nRowIdx];
            // is this the selection?
            if(currScale.type == self.selectedScaleType)
            {
                // yes, remember which row it is...
                nSelectedRowIdx = nRowIdx;
                break;  // exit loop we have answer
            }
        }
    }
    
    // and mark this row as selected 
    NSIndexPath *ipSelectedRow = [NSIndexPath indexPathForRow:nSelectedRowIdx inSection:0];
    [self.tvScaleTable selectRowAtIndexPath:ipSelectedRow animated:NO scrollPosition:UITableViewScrollPositionTop];
    //report the selection to the main view
    [self.delegate flipsideViewController:self selectedScale:[self selectedScaleForType:self.selectedScaleType]];

}

- (void)viewDidUnload
{
    [self setTvScaleTable:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
}

-(Scale *)selectedScaleForType:(enum eScaleType)eValue
{
    Scale *desiredScale = nil;
    for (Scale *currScale in m_scScaleAr) {
        if(currScale.type == eValue)
        {
            desiredScale = currScale;
            break;
        }
    }
    return desiredScale;
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return UIInterfaceOrientationIsLandscape(interfaceOrientation);

}

#pragma mark - Actions

- (IBAction)done:(id)sender
{
    //report the selection to the main view
    [self.delegate flipsideViewController:self selectedScale:[self selectedScaleForType:self.selectedScaleType]];
    
    // and close this [info] window...
    [self.delegate flipsideViewControllerDidFinish:self];
}

#pragma mark - <UITableViewDataSource> methods

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return [m_scScaleAr count];  
}

- (NSString *)tableView:(UITableView *)tableView titleForHeaderInSection:(NSInteger)section
{
    return @"Select Scale:";
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    UITableViewCell* cell = [tableView dequeueReusableCellWithIdentifier:@"ScaleCell"];
    
    if (cell == nil) {
        cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleSubtitle reuseIdentifier:@"ScaleCell"];
    }
    
    Scale *scaleForRow = [m_scScaleAr objectAtIndex:indexPath.row];
    cell.detailTextLabel.text = scaleForRow.description; 
    cell.textLabel.text = scaleForRow.title;
    cell.tag = scaleForRow.type;
    if(cell.tag == self.selectedScaleType)
    {
        cell.accessoryType = UITableViewCellAccessoryCheckmark;
    }
    else
    {
        cell.accessoryType = UITableViewCellAccessoryNone;
    }
    return cell;
}

#pragma mark - <UITableViewDelegate> methods

// Called after the user changes the selection.
- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    UITableViewCell *currCell = [tableView cellForRowAtIndexPath:indexPath];
    currCell.accessoryType = UITableViewCellAccessoryCheckmark;
    self.selectedScaleType = currCell.tag;
    
    //report the selection to the main view
    [self.delegate flipsideViewController:self selectedScale:[self selectedScaleForType:self.selectedScaleType]];
}

- (void)tableView:(UITableView *)tableView didDeselectRowAtIndexPath:(NSIndexPath *)indexPath 
{
    UITableViewCell *currCell = [tableView cellForRowAtIndexPath:indexPath];
    currCell.accessoryType = UITableViewCellAccessoryNone;
}

@end
