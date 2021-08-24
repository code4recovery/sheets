# Google Sheets Importer

As of 8/12/21, Google has begun deprecating `v3` of its Sheets API, which several AA services were using (Online Intergroup, TSML UI, Meeting Guide). Version 4 makes several changes, one of them being that requests require an API key.

This service is intended to fill the gap between the new `v4` of the Sheets API and Meeting Guide services.

1. users will sign up once at sheets.code4recovery.org (don’t do this now, not ready)
1. they will register their feed with a name and sheet ID and it will return a URL
1. they can then come back any time to refresh the feed
1. there will be an optional Google Sheets add-on which will enable geocoding, slug generation, and basic data checking, as well as a dropdown menu item to “Publish Data" (register or refresh feed right from the sheet)

Benefits of this system are:

-   static JSON files, no database / cookies / processing
-   end user browsers don’t talk to Google
-   servants don’t need an API key
-   API keys not exposed to end users
-   waiting to publish allows servants to be in draft mode when editing the sheet

## Next steps

-   [x] Logging in with Google OAuth
-   [x] Create / edit feed listings
-   [x] Refresh feeds
-   [x] Security to restrict editing to feed owners
-   [x] Delete feeds
-   [x] No feeds message
-   [x] Mapbox key add-on to TSML UI embed code
-   [x] Authenticate and send to intended URL
-   [ ] Mobile view
-   [ ] Sign out dropdown is wack
-   [ ] Form validation
-   [ ] Show import errors (e.g. duplicate slugs, invalid types)
-   [ ] Transfer feed ownership
-   [ ] Localize in French and Spanish
-   [ ] Ability to view un-owned feeds?

## Google Sheets add-on

-   [ ] Publish JSON from the Google Sheets add-on
-   [ ] Publish the add-on to the Google Workspace Marketplace
