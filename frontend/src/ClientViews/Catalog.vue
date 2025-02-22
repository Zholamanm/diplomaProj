<template>
  <div id="main-container" class="main-container nav-effect-1">
    <div class="main clearfix">
      <div class="page-container">
        <div class="page-title category-title">
        </div>

        <section id="book_list">

          <div class="toolbar row">
            <div class="filter-options small-12 medium-9 columns">
              <a href="#" class="filter-item active" data-group="all">All Categories</a>
              <a href="#" class="filter-item" data-group="fantasy">Fantasy</a>
              <a href="#" class="filter-item" data-group="sci-fi">Sci-Fi</a>
              <a href="#" class="filter-item" data-group="classic">Classics</a>
              <a href="#" class="filter-item" data-group="fairy">Fairy Tale</a>
              <a href="#" class="filter-item" data-group="young">Young Adult</a>
            </div>

            <div class="small-12 medium-3 columns">
              <select class="sort-options">
                <option value="" disabled selected>Sort by</option>
                <option value="">Featured</option>
                <option value="title">Alphabetical</option>
                <option value="date-created">Published</option>
              </select>
            </div>
          </div>

          <div class="grid-shuffle">
            <ul id="grid" class="row" style="display: flex">

              <li class="book-item small-12 medium-6 columns" data-groups='["classic"]' data-date-created='1937'
                  data-title='Of Mice and Men' data-color='#fcc278'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_1-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">Of Mice and Men</h3>
                  <p class="author">by John Steinbeck &bull; 1937</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_1-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">Of Mice and Men</h2>
                    <p class="author">by John Steinbeck</p>
                    <p class="published">1937</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["classic","young"]' data-date-created='1951'
                  data-title='The Catcher in the Rye' data-color='#009c8b'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_2-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">The Catcher in the Rye</h3>
                  <p class="author">by J.D. Salinger &bull; 1951</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_2-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">The Catcher in the Rye</h2>
                    <p class="author">by J.D. Salinger</p>
                    <p class="published">1951</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["classic","sci-fi"]'
                  data-date-created='1949' data-title='1984' data-color='#9c9688'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_3-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">1984</h3>
                  <p class="author">by George Orwell &bull; 1949</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_3-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">1984</h2>
                    <p class="author">by George Orwell</p>
                    <p class="published">1949</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["classic","young"]' data-date-created='1954'
                  data-title='Lord of the Flies' data-color='#db2e0f'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_4-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">Lord of the Flies</h3>
                  <p class="author">by William Golding &bull; 1954</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_4-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">Lord of the Flies</h2>
                    <p class="author">by William Golding</p>
                    <p class="published">1954</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["classic"]' data-date-created='1925'
                  data-title='The Great Gatsby' data-color='#e3b005'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_5-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">The Great Gatsby</h3>
                  <p class="author">by F. Scott Fitzgerald &bull; 1925</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_5-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">The Great Gatsby</h2>
                    <p class="author">by F. Scott Fitzgerald</p>
                    <p class="published">1925</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["classic"]' data-date-created='1851'
                  data-title='Moby Dick' data-color='#a9afad'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_6-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">Moby Dick</h3>
                  <p class="author">by Herman Melville &bull; 1851</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_6-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">Moby Dick</h2>
                    <p class="author">by Herman Melville</p>
                    <p class="published">1851</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["classic","sci-fi"]'
                  data-date-created='1962' data-title='A Clockwork Orange' data-color='#fe7b21'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_7-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">A Clockwork Orange</h3>
                  <p class="author">by Anthony Burgess &bull; 1962</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_7-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">A Clockwork Orange</h2>
                    <p class="author">by Anthony Burgess</p>
                    <p class="published">1962</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["classic","fairy"]' data-date-created='1835'
                  data-title='The Princess and the Pea' data-color='#aea98c'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_8-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">The Princess and the Pea</h3>
                  <p class="author">by Hans Christian Andersen &bull; 1835</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_8-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">The Princess and the Pea</h2>
                    <p class="author">by Hans Christian Andersen</p>
                    <p class="published">1835</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["classic","fairy"]' data-date-created='1900'
                  data-title='The Wonderful Wizard of Oz' data-color='#705e1e'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_9-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">The Wonderful Wizard of Oz</h3>
                  <p class="author">by L. Frank Baum &bull; 1900</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_9-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">The Wonderful Wizard of Oz</h2>
                    <p class="author">by L. Frank Baum</p>
                    <p class="published">1900</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["classic","fairy"]' data-date-created='1934'
                  data-title='Mary Poppins' data-color='#939894'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_10-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">Mary Poppins</h3>
                  <p class="author">by P.L. Travers &bull; 1934</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_10-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">Mary Poppins</h2>
                    <p class="author">by P.L. Travers</p>
                    <p class="published">1934</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["classic","fairy"]' data-date-created='1740'
                  data-title='Beauty and the Beast' data-color='#b4aa91'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_11-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">Beauty and the Beast</h3>
                  <p class="author">by Gabrielle-Suzanne Barbot de Villeneuve &bull; 1740</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_11-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">Beauty and the Beast</h2>
                    <p class="author">by Gabrielle-Suzanne Barbot de Villeneuve</p>
                    <p class="published">1740</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["classic","fairy"]' data-date-created='1812'
                  data-title='Rapunzel' data-color='#725d64'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_12-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">Rapunzel</h3>
                  <p class="author">by Friedrich Schulz &bull; 1812</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_12-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">Rapunzel</h2>
                    <p class="author">by Friedrich Schulz</p>
                    <p class="published">1812</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["fantasy","young"]' data-date-created='1997'
                  data-title="Harry Potter and the Sorcerer's Stone" data-color='#7a4930'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_13-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">Harry Potter and the Sorcerer's Stone</h3>
                  <p class="author">by J.K. Rowling &bull; 1997</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_13-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">Harry Potter and the Sorcerer's Stone</h2>
                    <p class="author">by J.K. Rowling</p>
                    <p class="published">1997</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["fantasy","young"]' data-date-created='1998'
                  data-title='Harry Potter and the Chamber of Secrets' data-color='#800020'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_14-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">Harry Potter and the Chamber of Secrets</h3>
                  <p class="author">by J.K. Rowling &bull; 1998</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_14-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">Harry Potter and the Chamber of Secrets</h2>
                    <p class="author">by J.K. Rowling</p>
                    <p class="published">1998</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["fantasy","young"]' data-date-created='1999'
                  data-title="Harry Potter and the Prisoner of Azkaban" data-color='#603060'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_15-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">Harry Potter and the Prisoner of Azkaban</h3>
                  <p class="author">by J.K. Rowling &bull; 1999</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_15-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">Harry Potter and the Prisoner of Azkaban</h2>
                    <p class="author">by J.K. Rowling</p>
                    <p class="published">1999</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["fantasy","young"]' data-date-created='2000'
                  data-title="Harry Potter and the Goblet of Fire" data-color='#9a9c43'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_16-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">Harry Potter and the Goblet of Fire</h3>
                  <p class="author">by J.K. Rowling &bull; 2000</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_16-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">Harry Potter and the Goblet of Fire</h2>
                    <p class="author">by J.K. Rowling</p>
                    <p class="published">2000</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["fantasy","young"]' data-date-created='2003'
                  data-title="Harry Potter and the Order of the Phoenix" data-color='#2c63a0'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_17-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">Harry Potter and the Order of the Phoenix</h3>
                  <p class="author">by J.K. Rowling &bull; 2003</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_17-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">Harry Potter and the Order of the Phoenix</h2>
                    <p class="author">by J.K. Rowling</p>
                    <p class="published">2003</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["fantasy","young"]' data-date-created='2005'
                  data-title="Harry Potter and the Half-Blood Prince" data-color='#658539'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_18-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">Harry Potter and the Half-Blood Prince</h3>
                  <p class="author">by J.K. Rowling &bull; 2005</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_18-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">Harry Potter and the Half-Blood Prince</h2>
                    <p class="author">by J.K. Rowling</p>
                    <p class="published">2005</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

              <li class="book-item small-12 medium-6 columns" data-groups='["fantasy","young"]' data-date-created='2007'
                  data-title="Harry Potter and the Deathly Hallows" data-color='#b06010'>
                <div class="bk-img">
                  <div class="bk-wrapper">
                    <div class="bk-book bk-bookdefault">
                      <div class="bk-front">
                        <div class="bk-cover"
                             style="background-image: url('http://interactivejoe.com/book-viewer/assets/images/bk_19-small.jpg')"></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>
                <div class="item-details">
                  <h3 class="book-item_title">Harry Potter and the Deathly Hallows</h3>
                  <p class="author">by J.K. Rowling &bull; 2007</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tellus nisi, eget pulvinar in,
                    molestie et arcu.</p>
                  <a href="#" class="button ">Details</a>
                </div>

                <div class="overlay-details">
                  <a href="#" class="close-overlay-btn">Close</a>
                  <div class="overlay-image">
                    <img src="http://interactivejoe.com/book-viewer/assets/images/bk_19-large.jpg" alt="Book Cover">
                    <div class="back-color"></div>
                  </div>
                  <div class="overlay-desc activated">
                    <h2 class="overlay_title">Harry Potter and the Deathly Hallows</h2>
                    <p class="author">by J.K. Rowling</p>
                    <p class="published">2007</p>
                    <p class="synopsis">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis
                      sem. Nunc sed tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam
                      eu metus et purus rutrum malesuada. Aenean in auctor mauris,
                      non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim lectus, id
                      tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                    <a href="#" class="button preview">Preview</a>
                  </div>
                  <div class="overlay-preview">
                    <a href="#" class="back-preview-btn">Back</a>
                    <h4 class="preview-title">Preview</h4>
                    <div class="preview-content">
                      <h5>Chapter 1</h5>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus convallis sem. Nunc sed
                        tristique augue. Aenean at nulla vel lacus volutpat bibendum vitae ut nibh. Aliquam eu metus et
                        purus rutrum malesuada. Aenean in auctor
                        mauris, non vulputate libero. Nullam auctor, purus ut cursus convallis, lectus tellus dignissim
                        lectus, id tempor ipsum leo ut nulla. Vestibulum vitae elit erat.<br>&nbsp;<br>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </li>

            </ul>
          </div>

        </section>

      </div>

      <!-- Footer Content -->
      <footer id="footer" class="page-footer">
        <div class="row footer-wrapper">
          <div class="original-version small-12 columns"><a href="http://interactivejoe.com/book-viewer/"
                                                            target="_blank"><em>Original Version can be found here.</em></a>
          </div>
          <div class="copyright small-12 columns">&copy; 2016 - <a href="http://interactivejoe.com/" target="_blank">InteractiveJoe</a>
          </div>
        </div>
      </footer>

    </div>
    <div class="main-overlay">
      <div class="overlay-full"></div>
    </div>
  </div>
</template>
<script>
import $ from 'jquery';
import Shuffle from 'shufflejs';

export default {
  name: 'CatalogView',
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      errors: {},
      globalError: null,
    };
  },
  methods: {
    loadCatalog() {
      $("li.book-item").each(function () {
        var $this = $(this);

        $this.find(".bk-front > div").css('background-color', $(this).data("color"));
        $this.find(".bk-left").css('background-color', $(this).data("color"));
        $this.find(".back-color").css('background-color', $(this).data("color"));

        $this.find(".item-details a.button").on('click', function () {
          displayBookDetails($this);
        });
      });

      function displayBookDetails(el) {
        var $this = $(el);
        $('.main-container').addClass('prevent-scroll');
        $('.main-overlay').fadeIn();

        $this.find('.overlay-details').clone().prependTo('.main-overlay');

        $('a.close-overlay-btn').on('click', function (e) {
          e.preventDefault();
          $('.main-container').removeClass('prevent-scroll');
          $('.main-overlay').fadeOut();
          $('.main-overlay').find('.overlay-details').remove();
        });

        $('.main-overlay a.preview').on('click', function () {
          $('.main-overlay .overlay-desc').toggleClass('activated');
          $('.main-overlay .overlay-preview').toggleClass('activated');
        });

        $('.main-overlay a.back-preview-btn').on('click', function () {
          $('.main-overlay .overlay-desc').toggleClass('activated');
          $('.main-overlay .overlay-preview').toggleClass('activated');
        });
      }

      $('.overlay-full').on('click', function () {
        $('.main-container').removeClass('prevent-scroll');
        $(this).parent().fadeOut();
        $(this).parent().find('.overlay-details').remove();
      });
      var bookList = function (element) {
        this.element = element;

        this.shuffle = new Shuffle(element, {
          itemSelector: '.book-item',
        });

        this._activeFilters = [];
        this.addFilterButtons();
        this.addSorting();
        this.addSearchFilter();
        this.mode = 'exclusive';
      };

      bookList.prototype.toArray = function (arrayLike) {
        return Array.prototype.slice.call(arrayLike);
      };


      bookList.prototype.toggleMode = function () {
        if (this.mode === 'additive') {
          this.mode = 'exclusive';
        } else {
          this.mode = 'additive';
        }
      };


      bookList.prototype.addFilterButtons = function () {
        var options = document.querySelector('.filter-options');
        if (!options) {
          return;
        }
        var filterButtons = this.toArray(options.children);

        filterButtons.forEach(function (button) {
          button.addEventListener('click', this._handleFilterClick.bind(this), false);
        }, this);
      };


      bookList.prototype._handleFilterClick = function (evt) {
        var btn = evt.currentTarget;
        var isActive = btn.classList.contains('active');
        var btnGroup = btn.getAttribute('data-group');

        if (this.mode === 'additive') {
          if (isActive) {
            this._activeFilters.splice(this._activeFilters.indexOf(btnGroup));
          } else {
            this._activeFilters.push(btnGroup);
          }

          btn.classList.toggle('active');
          this.shuffle.filter(this._activeFilters);

        } else {
          this._removeActiveClassFromChildren(btn.parentNode);

          var filterGroup;
          if (isActive) {
            btn.classList.remove('active');
            filterGroup = Shuffle.ALL_ITEMS;
          } else {
            btn.classList.add('active');
            filterGroup = btnGroup;
          }

          this.shuffle.filter(filterGroup);
        }
      };


      bookList.prototype._removeActiveClassFromChildren = function (parent) {
        var children = parent.children;
        for (var i = children.length - 1; i >= 0; i--) {
          children[i].classList.remove('active');
        }
      };


      bookList.prototype.addSorting = function () {
        var menu = document.querySelector('.sort-options');
        if (!menu) {
          return;
        }
        menu.addEventListener('change', this._handleSortChange.bind(this));
      };


      bookList.prototype._handleSortChange = function (evt) {
        var value = evt.target.value;
        var options = {};

        function sortByDate(element) {
          return element.getAttribute('data-created');
        }

        function sortByTitle(element) {
          return element.getAttribute('data-title').toLowerCase();
        }

        if (value === 'date-created') {
          options = {
            reverse: true,
            by: sortByDate,
          };
        } else if (value === 'title') {
          options = {
            by: sortByTitle,
          };
        }

        this.shuffle.sort(options);
      };


      bookList.prototype.addSearchFilter = function () {
        var searchInput = document.querySelector('.shuffle-search');
        if (!searchInput) {
          return;
        }
        searchInput.addEventListener('keyup', this._handleSearchKeyup.bind(this));
      };


      bookList.prototype._handleSearchKeyup = function (evt) {
        var searchInput = document.querySelector('.shuffle-search');
        var searchText = evt.target.value.toLowerCase();


        if (searchInput && searchInput.value) {
          $('.catalog-search').addClass('input--filled');
        } else {
          $('.catalog-search').removeClass('input--filled');
        }

        this.shuffle.filter(function (element, shuffle) {


          if (shuffle.group !== Shuffle.ALL_ITEMS) {

            var groups = JSON.parse(element.getAttribute('data-groups'));
            var isElementInCurrentGroup = groups.indexOf(shuffle.group) !== -1;


            if (!isElementInCurrentGroup) {
              return false;
            }
          }

          var titleElement = element.querySelector('.book-item_title');
          var titleText = titleElement.textContent.toLowerCase().trim();

          return titleText.indexOf(searchText) !== -1;
        });
      };


      document.addEventListener('DOMContentLoaded', function () {
        window.book_list = new bookList(document.getElementById('grid'));
      });
    }
  },
  mounted() {
    this.loadCatalog()
  }
};
</script>
<style>
@import url(https://fonts.googleapis.com/css?family=Lato:400,300,700,900);
@import url(https://fonts.googleapis.com/css?family=Roboto+Slab:400,700);
@import url("https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css");
</style>
<style scoped>
html,
body,
.main,
.main-container {
  height: 100%;
}

body {
  font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
  color: #313131;
  background: #ecf0f1;
}

/*
 *  Typography
*/
body,
p,
a,
li {
  font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 15px;
}

a {
  color: #219e9a;
}

h2,
h3 {
  margin-top: 6px;
  margin-bottom: 6px;
  font-size: 28px;
  font-weight: bold;
  letter-spacing: -1px;
  color: #313131;
}

h2 {
  font-size: 28px;
}

h3 {
  font-size: 24px;
}

h4 {
  margin-bottom: 12px;
  font-size: 22px;
  line-height: 40px;
  color: rgba(49, 49, 49, 0.7);
}

p:not(.author) {
  font-size: 15px;
  font-weight: 300;
  line-height: 1.4;
}

p.author {
  margin-bottom: 10px;
  letter-spacing: -1px;
  font-weight: 400;
  color: rgba(49, 49, 49, 0.5);
}

/*
 *  Button
*/
a.button {
  margin-bottom: 0;
  padding: 8px 14px;
  font-size: 14px;
  font-weight: 600;
  border-radius: 3px;
  background-color: rgba(49, 49, 49, 0.5);
}
a.button:hover, a.button:focus {
  background-color: #219e9a;
}

/*
 *  Header
*/
.page-header {
  position: relative;
  margin-bottom: 55px;
  width: 100%;
  border-bottom: 1px solid #d2d6d5;
  background-color: #fff;
}

.main-logo {
  display: inline-block;
  padding: 1em;
  width: auto;
}
.main-logo a.logo {
  display: block;
  width: 150px;
  height: 40px;
  text-indent: -9999px;
  background: url("http://interactivejoe.com/book-viewer/assets/images/logo.svg");
  background-color: #fff;
  transition: background-color 250ms ease-out;
}
.main-logo a.logo:hover, .main-logo a.logo:focus {
  background-color: #ecf0f1;
}

.menu-search {
  float: right;
  width: calc(100% - 200px);
}

/*
 *  Search Input
*/
.catalog-search {
  position: relative;
  margin: 0 20px;
  max-width: 275px;
  width: calc(100% - 2em);
  vertical-align: top;
  overflow: hidden;
  float: right;
}

.input_field {
  position: relative;
  display: block;
  float: right;
  margin-top: 10px;
  padding: 14px 7px 0;
  width: 100%;
  border: none;
  border-radius: 0;
  color: #313131;
  font-weight: normal;
  font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
  background: none;
  box-shadow: none;
  -webkit-appearance: none;
  /* for box shadows to show on iOS */
}
.input_field:focus {
  outline: none;
  border: none;
  background: none;
  box-shadow: none;
  -webkit-appearance: none;
}
.input_field:focus .input_label-content {
  bottom: 20px;
}

.input_label {
  position: absolute;
  display: inline-block;
  bottom: 0;
  left: 0;
  padding: 0 0.25em;
  width: 100%;
  height: calc(100% - 1em);
  color: #d2d6d5;
  font-weight: light;
  font-size: 15px;
  text-align: left;
  pointer-events: none;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.input_label:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: calc(100% - 10px);
  border-bottom: 1px solid rgba(49, 49, 49, 0.45);
}
.input_label:after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  margin-top: 2px;
  width: 100%;
  height: calc(100% - 10px);
  border-bottom: 3px solid #219e9a;
  transform: translate3d(-100%, 0, 0);
  transition: transform 0.3s;
}

.input_label-content {
  position: absolute;
  width: 100%;
  bottom: 14px;
}

.input_label-search {
  position: relative;
  display: block;
  color: rgba(49, 49, 49, 0.45);
}
.input_label-search:after {
  content: "";
  position: absolute;
  top: 7px;
  right: 5px;
  font-family: "fontawesome";
}

.input_field:focus + .input_label::after,
.input--filled .input_label::after {
  transform: translate3d(0, 0, 0);
}

.toolbar {
  margin-bottom: 30px;
  border-bottom: 1px solid #d2d6d5;
}
.toolbar select {
  margin-bottom: 7px;
  color: #313131;
  font-size: 14px;
  border: none;
  background-color: transparent;
}
.toolbar .filter-options {
  line-height: 40px;
}
.toolbar a.filter-item {
  margin-right: 16px;
  padding-bottom: 18px;
  font-size: 14px;
  color: #313131;
  border-bottom: 0px solid transparent;
  transition: all 250ms ease-out;
}
.toolbar a.filter-item:last-child {
  margin-right: 0;
}
.toolbar a.filter-item.active {
  padding-bottom: 15px;
  color: #219e9a;
  font-weight: bold;
  border-bottom: 3px solid #219e9a;
}

#grid {
  margin-bottom: 60px;
}

.book-item {
  left: unset !important;
  width: 50%;
  margin: 15px 0;
  padding: 15px;
  list-style-type: none;
}
.book-item:hover .item-img img {
  box-shadow: 0px 0px 10px 0px rgba(49, 49, 49, 0.25);
}
.book-item:hover a.button {
  background-color: #219e9a;
}
.book-item:hover .bk-bookdefault {
  transform: rotate3d(0, 1, 0, 25deg);
}
.book-item:hover .bk-back {
  opacity: 1;
}
.book-item .item-img {
  display: inline-block;
  float: left;
  padding-right: 30px;
}
.book-item .item-img img {
  box-shadow: 0 0 0 0 transparent;
  transition: all 250ms ease-out;
}
.book-item .item-details {
  padding-right: 30px;
}
.book-item h3 {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.book-item p:not(.author) {
  display: block;
  display: -webkit-box;
  height: 63px;
  /* Fallback for non-webkit */
  font-size: 15px;
  line-height: 1.4;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

/*
 *  Book Rotate
*/
.bk-img {
  position: relative;
  display: inline-block;
  float: left;
  padding-right: 30px;
  list-style: none;
  /* Individual style & artwork */
}
.bk-img .bk-wrapper {
  position: relative;
  width: 150px;
  height: 215px;
  float: left;
  z-index: 1;
  perspective: 1400px;
}
.bk-img .bk-wrapper:last-child {
  margin-right: 0;
}
.bk-img .bk-book {
  position: absolute;
  width: 100%;
  height: 215px;
  transform-style: preserve-3d;
  transition: transform 0.5s;
}
.bk-img .bk-book > div,
.bk-img .bk-front > div {
  display: block;
  position: absolute;
}
.bk-img .bk-front {
  transform-style: preserve-3d;
  transform-origin: 0% 50%;
  transition: transform 0.5s;
  transform: translate3d(0, 0, 20px);
  z-index: 10;
}
.bk-img .bk-front > div {
  z-index: 1;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  transform-style: preserve-3d;
  border-radius: 0 3px 3px 0;
  box-shadow: inset 4px 0 10px rgba(0, 0, 0, 0.1);
}
.bk-img .bk-front:after {
  content: "";
  position: absolute;
  top: 1px;
  bottom: 1px;
  left: -1px;
  width: 1px;
}
.bk-img .bk-front,
.bk-img .bk-back,
.bk-img .bk-front > div {
  width: 150px;
  height: 215px;
}
.bk-img .bk-left,
.bk-img .bk-right {
  width: 40px;
  left: -20px;
}
.bk-img .bk-back {
  transform: rotate3d(0, 1, 0, -180deg) translate3d(0, 0, 20px);
  box-shadow: 5px 7px 15px rgba(0, 0, 0, 0.3);
  border-radius: 3px 0 0 3px;
  opacity: 0;
  transition: opacity 250ms ease-out;
}
.bk-img .bk-back:after {
  content: "";
  position: absolute;
  top: 0;
  left: 10px;
  bottom: 0;
  width: 3px;
  background: rgba(0, 0, 0, 0.06);
  box-shadow: 1px 0 3px rgba(255, 255, 255, 0.1);
}
.bk-img .bk-left {
  height: 215px;
  transform: rotate3d(0, 1, 0, -90deg);
}
.bk-img .bk-left h2 {
  width: 215px;
  height: 40px;
  transform-origin: 0 0;
  transform: rotate(90deg) translateY(-40px);
}
.bk-img .bk-cover {
  /*background-image: url(../images/1.png);*/
  background-repeat: no-repeat;
  background-position: 10px 40px;
}
.bk-img .bk-cover:after {
  content: "";
  position: absolute;
  top: 0;
  left: 10px;
  bottom: 0;
  width: 3px;
  background: rgba(0, 0, 0, 0.06);
  box-shadow: 1px 0 3px rgba(255, 255, 255, 0.1);
}
.bk-img .bk-cover {
  background-repeat: no-repeat;
  background-position: top left !important;
}
.bk-img .bk-front > div,
.bk-img .bk-left {
  background-color: #219e9a;
}

/*
 *  Lightbox
*/
.main-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: none;
  background-color: rgba(49, 49, 49, 0.65);
}
.main-overlay .overlay-full {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
.main-overlay .overlay-details {
  position: absolute;
  display: block;
  z-index: 1;
  top: 50%;
  left: 50%;
  width: 100%;
  max-width: 800px;
  max-height: 480px;
  padding: 40px;
  overflow: hidden;
  border-radius: 3px;
  background-color: #fff;
  box-shadow: 0px 2px 1px 2px rgba(0, 0, 0, 0.3);
  transform: translate(-50%, -50%);
}
.main-overlay .overlay-image {
  display: inline-block;
  margin-right: 30px;
  max-width: 275px;
  vertical-align: top;
}
.main-overlay .overlay-image img {
  position: relative;
  display: inline-block;
  z-index: 1;
  box-shadow: -12px 12px 15px -5px rgba(0, 0, 0, 0.3);
}
.main-overlay .overlay-image .back-color {
  position: absolute;
  top: 0;
  left: 0;
  width: 275px;
  height: 100%;
  border-top-left-radius: 3px;
  border-bottom-left-radius: 3px;
  background-color: green;
}
.main-overlay .close-overlay-btn {
  position: absolute;
  top: 15px;
  right: 15px;
  width: 30px;
  height: 30px;
  opacity: 0.3;
  text-indent: -9999px;
  transition: opacity 250ms ease-out;
}
.main-overlay .close-overlay-btn:hover {
  opacity: 1;
}
.main-overlay .close-overlay-btn:before {
  content: " ";
  position: absolute;
  left: 15px;
  width: 2px;
  height: 33px;
  background-color: #313131;
}
.main-overlay .close-overlay-btn:after {
  content: " ";
  position: absolute;
  left: 15px;
  width: 2px;
  height: 33px;
  background-color: #313131;
}
.main-overlay .close-overlay-btn:before {
  transform: rotate(45deg);
}
.main-overlay .close-overlay-btn:after {
  transform: rotate(-45deg);
}
.main-overlay .back-preview-btn {
  position: absolute;
  top: 7px;
  left: -34px;
  width: 30px;
  height: 30px;
  opacity: 0.3;
  text-indent: -9999px;
  transition: opacity 250ms ease-out;
}
.main-overlay .back-preview-btn:hover {
  opacity: 1;
}
.main-overlay .back-preview-btn:before {
  content: " ";
  position: absolute;
  left: 15px;
  width: 2px;
  height: 15px;
  background-color: #313131;
}
.main-overlay .back-preview-btn:after {
  content: " ";
  position: absolute;
  top: 10px;
  left: 15px;
  width: 2px;
  height: 15px;
  background-color: #313131;
}
.main-overlay .back-preview-btn:before {
  transform: rotate(45deg);
}
.main-overlay .back-preview-btn:after {
  transform: rotate(-45deg);
}
.main-overlay .overlay-desc {
  display: inline-block;
  margin-top: -400px;
  width: calc(100% - 320px);
  vertical-align: top;
  transition: all 500ms ease-out;
}
.main-overlay .overlay-desc.activated {
  display: inline-block;
  margin-top: 0;
}
.main-overlay .overlay-preview {
  position: relative;
  display: inline-block;
  float: right;
  margin-top: 40px;
  width: calc(100% - 310px);
  vertical-align: top;
  transition: all 500ms ease-out;
}
.main-overlay .overlay-preview.activated {
  margin-top: -430px;
}
.main-overlay .preview-content {
  padding-right: 24px;
  padding-top: 10px;
  display: block;
  display: -webkit-box;
  height: 360px;
  /* Fallback for non-webkit */
  font-size: 15px;
  line-height: 1.5;
  -webkit-line-clamp: 16;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  overflow: scroll;
  text-overflow: clip;
  font-weight: 400;
}
.main-overlay .preview-content h5,
.main-overlay .preview-content p {
  font-family: "Roboto Slab", serif;
}
.main-overlay .preview-content h5 {
  font-weight: bold;
}
.main-overlay .preview-content p {
  font-weight: normal;
}
.main-overlay .preview-content:before {
  content: "";
  position: absolute;
  left: 0;
  top: 40px;
  width: 100%;
  heightheight: 30px;
  background: rgba(255, 255, 255, 0);
  background: linear-gradient(to top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.8) 30%, white 80%);
}
.main-overlay .preview-content:after {
  content: "";
  position: absolute;
  left: 0;
  bottom: 0;
  width: 100%;
  height: 50px;
  background: rgba(255, 255, 255, 0);
  background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.8) 30%, white 80%);
}

.overlay-details {
  display: none;
}

/*
 *  Footer
*/
#footer {
  margin-top: 60px;
  padding: 15px 0 20px;
  border-top: 1px solid #fff;
  background-color: rgba(49, 49, 49, 0.5);
}
#footer div,
#footer a,
#footer p {
  color: #fff;
  font-size: 12px;
  text-align: center;
}
</style>