# iqnection-silverstripe-modules-seo
SilverStripe 4 SEO Module

### Adds fields for Google Analytics code. 
When populated, IQ templating will automatically insert code into HTML head

### Adds additional page variables for SEO
- MetaTitle
- NoFollow: can be used in templates to set a page link to rel="nofollow"
- URLRedirects: enter old URL paths, if path doesn't exist, system will search for path and redirect to page that has path entered here
- MetaKeywords: for those that still use this

## Adds fields for including additional tags/elements in <head></head>, and before </body> close

## If using Google Tag Manager, be sure to add the following code to your templates

# Add inside your <head> tag before any other scripts:
<% if $SiteConfig.GoogleTagManagerHeadCode %>$SiteConfig.GoogleTagManagerHeadCode.RAW<% end_if %>

# Add just insode your opening <body> element
<% if $SiteConfig.GoogleTagManagerBodyCode %>$SiteConfig.GoogleTagManagerBodyCode.RAW<% end_if %>
