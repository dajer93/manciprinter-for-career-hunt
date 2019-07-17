<?php

/**
 * This function runs when the user activates the plugin.
 */
function order_management_activation(){
  add_option( 'order_management_state', json_decode('{
    "1": {
        "id": "1",
        "name": "Kint 1",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "2": {
        "id": "2",
        "name": "Kint 2",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "3": {
        "id": "3",
        "name": "Kint 3",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "4": {
        "id": "4",
        "name": "Kint 4",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "5": {
        "id": "5",
        "name": "Kint 5",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "6": {
        "id": "6",
        "name": "Kint 6",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "7": {
        "id": "7",
        "name": "Kint 7",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "8": {
        "id": "8",
        "name": "Kint 8",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "9": {
        "id": "9",
        "name": "Bent 1",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "10": {
        "id": "10",
        "name": "Bent 2",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "11": {
        "id": "11",
        "name": "Bent 3",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "12": {
        "id": "12",
        "name": "Bent 4",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "13": {
        "id": "13",
        "name": "Bent 5",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "14": {
        "id": "14",
        "name": "Bent 6",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "15": {
        "id": "15",
        "name": "Bent 7",
        "orders": {},
        "notes": "",
        "entries": []
    },
    "16": {
        "id": "16",
        "name": "Bent 8",
        "orders": {},
        "notes": "",
        "entries": []
    }
}'));
  add_option( 'order_management_pincode', '0000' );
}

