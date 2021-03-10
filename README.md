# PunktDe.FusionFeed

Render RSS / Atom feeds using Fusion prototypes. 

The Feed is accessed using a route with the alternative format "feed". 

## Example 

Given you have a blog and a blog listing document type named `Vendor.Site:Document.BlogListing`, just add a prototype with the name `Vendor.Site:Document.BlogListing.Feed` and the following Fusion code:

```
prototype(Vendor.Site:Document.BlogListing.Feed) < prototype(PunktDe.FusionFeed:Feed) {

    channel {
         title = ${q(documentNode).property('title')}
 
         items = Neos.Fusion:DataStructure {
             item1 = PunktDe.FusionFeed:Item {
                 title = 'Test Document 1'
                 url = 'https://domain/path/to/your/article.html'
             }
 
             item2 = PunktDe.FusionFeed:Item {
                 title = 'Test Document 2'
                 url = 'https://domain/path/to/your/article2.html'
             }
         }
     }
 }
```

Internally the [php-rss-writer](https://github.com/suin/php-rss-writer) library is used. Have a look at their exmaple for a full list of available properties. 

## Installation

```
composer require punktde/fusion-feed
```
