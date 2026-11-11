/**
 * Keeps the classic header cart (count pill + mini-cart dropdown) and the
 * block-based Cart/Checkout in sync.
 *
 * - Block cart → header: the Cart block updates through the Store API and
 *   never fires the classic jQuery events, so we watch the `wc/store/cart`
 *   data store and ask wc-cart-fragments to refresh the header.
 * - Header → block cart: removing an item from the mini cart fires the
 *   classic `removed_from_cart` event; we tell the block store to refetch.
 */

(function ($) {
    'use strict';

    const STORE = 'wc/store/cart';
    let refreshTimer = null;

    function refreshHeaderCart() {
        window.clearTimeout(refreshTimer);
        refreshTimer = window.setTimeout(function () {
            $(document.body).trigger('wc_fragment_refresh');
        }, 300);
    }

    function cartSignature(cart) {
        if (!cart || !Array.isArray(cart.items)) {
            return '';
        }
        const lines = cart.items.map(function (item) {
            return item.key + ':' + item.quantity;
        });
        return lines.join(',') + '|' + (cart.totals ? cart.totals.total_price : '');
    }

    function watchBlockCart() {
        const data = window.wp && window.wp.data;
        if (!data || typeof data.select !== 'function') {
            return;
        }

        let store;
        try {
            store = data.select(STORE);
        } catch (err) {
            return; // Store not registered on this page.
        }
        if (!store || typeof store.getCartData !== 'function') {
            return;
        }

        let last = cartSignature(store.getCartData());
        let resolving = typeof store.hasFinishedResolution === 'function' &&
            !store.hasFinishedResolution('getCartData');

        data.subscribe(function () {
            const select = data.select(STORE);
            const next = cartSignature(select.getCartData());
            if (next === last) {
                return;
            }
            last = next;

            // Ignore the swap from the store's empty default to the first
            // real response; only react to changes after that.
            const resolved = typeof select.hasFinishedResolution !== 'function' ||
                select.hasFinishedResolution('getCartData');
            if (resolved && !resolving) {
                refreshHeaderCart();
            }
            resolving = !resolved;
        });

        // Header mini-cart changes → make the Cart/Checkout block refetch.
        $(document.body).on('removed_from_cart added_to_cart', function () {
            const dispatch = data.dispatch(STORE);
            if (dispatch && typeof dispatch.invalidateResolutionForStore === 'function') {
                dispatch.invalidateResolutionForStore();
            }
        });
    }

    // Blocks fire these native events on add/remove (e.g. product blocks).
    ['wc-blocks_added_to_cart', 'wc-blocks_removed_from_cart'].forEach(function (name) {
        document.body.addEventListener(name, refreshHeaderCart);
    });

    // Block scripts register their stores before window load.
    $(window).on('load', watchBlockCart);
})(jQuery);
