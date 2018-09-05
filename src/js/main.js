// import $ from 'jquery'
// window.$ = $
// window.jQuery = $

import UIkit from 'uikit'
window.UIkit = UIkit
UIkit.use(require('uikit/dist/js/uikit-icons'))

function objectifyForm(formArray) {//serialize data function
  var returnArray = {};
  for (var i = 0; i < formArray.length; i++){
    returnArray[formArray[i]['name']] = formArray[i]['value'];
  }
  return returnArray;
}

document.querySelectorAll('.gallery, .lightbox').forEach(item => {
    UIkit.lightbox(item)
})

document.querySelectorAll('.js-gallery').forEach(gallery => {
    const main = gallery.querySelector('.js-gallery-main')
    const thumbnailsWrap = gallery.querySelector('.js-gallery-thumbnails')
    const thumbnails = thumbnailsWrap.querySelectorAll('img')
    const slider = UIkit.slider(thumbnailsWrap)

    thumbnails.forEach(img => {
        img.addEventListener('click', function(e) {
            e.preventDefault()
            thumbnails.forEach(row => row.classList.remove('active'))
            img.classList.add('active')
            slider.show(Array.prototype.indexOf.call(thumbnails, img))
            main.src = img.dataset.large
            main.dataset.full = img.dataset.full
        })
    })

    UIkit.util.on(thumbnailsWrap, 'itemshow', function (e) {
        e.target.querySelector('img').classList.add('active')
    })
})

// window.addEventListener('scroll', function(e) {
//     const totop = document.querySelector('.js-totop')
//
//     if (window.scrollY > 300) {
//         totop.classList.add('totop_visible')
//     } else {
//         totop.classList.remove('totop_visible')
//     }
// })

// document.addEventListener("DOMContentLoaded", function() {
//     const footer = document.querySelector('.js-footer')
//     const page = document.querySelector('.js-page')

//     page.style.minHeight = `${window.innerHeight - footer.offsetHeight}px`
// })

document.querySelectorAll('.catalog-menu__dropdown').forEach(item => {
    const params = {}

    if (window.matchMedia("(max-width: 959px)").matches) {
        params.mode = 'click'
    }

    UIkit.dropdown(item, params)

    UIkit.util.on(item, 'show', function(e) {
        document.querySelector('.catalog-menu').classList.add('catalog-menu_dropdown')
    })
    UIkit.util.on(item, 'hide', function(e) {
        document.querySelector('.catalog-menu').classList.remove('catalog-menu_dropdown')
    })
})

document.querySelectorAll('.js-product-tabs').forEach(tabs => {
  const list = tabs.querySelectorAll('li')
  tabs.classList.remove('uk-hidden')

  if (window.matchMedia("(max-width: 639px)").matches) {
    list.forEach(row => {
      const title = document.createElement('div')
      title.classList.add('uk-accordion-title', 'product-accordion__title')
      title.innerHTML = row.dataset.title
      const content = document.createElement('div')
      content.classList.add('uk-accordion-content', 'product-accordion__content')
      content.innerHTML = row.innerHTML
      row.innerHTML = ''
      row.appendChild(title)
      row.appendChild(content)
      UIkit.accordion(tabs)
    })
  } else {
    const heads = document.createElement('ul')
    heads.classList.add('uk-tab')
    tabs.classList.add('uk-switcher')
    list.forEach(row => {
      row.classList.add('product-tabs__panel')
      const head = document.createElement('li')
      head.classList.add('product-tabs__tab')
      head.innerHTML = row.dataset.title
      heads.appendChild(head)
      tabs.parentNode.insertBefore(heads, tabs)
      UIkit.tab(heads)
    })
  }
})

if (window.matchMedia("(max-width: 959px)").matches) {
    UIkit.dropdown(document.querySelector('.catalog-menu'), {
        mode: 'click'
    })
}

document.querySelectorAll('.js-crosssell-load-all').forEach(all => {
  all.addEventListener('click', function(event) {
    const list = document.querySelector('.js-crosssell-list')

    jQuery.post('/wp-admin/admin-ajax.php', {
      action: 'load_crosssell',
      product: event.target.dataset.product
    }, function(response) {
      list.innerHTML = response
      event.target.style.display = 'none'
    })
  })
})

document.querySelectorAll('.js-cart-accordion').forEach(accordion => {
  let current = 0

  const component = UIkit.accordion(accordion, {
    collapsible: false
  })

  jQuery(accordion).on('click', '.js-cart-accordion-next', function() {
    if (component.items.length > current + 1) {
      if (component.items[current + 1].classList.contains('uk-hidden')) {
        component.items[current + 1].classList.remove('uk-hidden')
      }
      component.toggle(current + 1)
    }
  })

  jQuery(accordion).on('click', '.js-cart-accordion-previous', function() {
    if (current > 0) {
      component.items[current].classList.add('uk-hidden')
      component.toggle(current - 1)
    }
  })

  // UIkit.util.on(accordion, 'show', (e, a, s) => {
  //   console.log(e, a, s)
  // })
})

const cart = jQuery('.woocommerce-cart-form');
cart.on('change', '.quantity input', function () {
  const data = objectifyForm(cart.serializeArray());
  data.update_cart = 'update_cart';

  cart.addClass('loading');
  jQuery.post(cart.attr('action'), data, function (response) {
    const new_cart = jQuery(document.createElement('div')).html(response).find('.woocommerce-cart-form')
    cart.html(new_cart.html());
    cart.removeClass('loading');
  });
});