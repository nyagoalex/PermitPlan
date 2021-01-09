export const itinerary =
    {
        id: 22,
        booking_id: 1,
        ref_no: '#STYY',
        days: [
            {
                priority: '1',
                name: 'Arrival',
                items: [ // prettier-ignore
                    {
                        id: '1',
                        type: 'transfer',
                        priority: 1,
                        duration: 30,
                        children: 2,
                        adults: 5,
                        text: 'Transfer back to Kigali Airport.'
                    },
                    {
                        id: '2',
                        type: 'accomodation',
                        priority: 2,
                        duration: 30,
                        children: 2,
                        adults: 5,
                        text: 'Sanctuary Gorilla Forest Camp Uganda'
                    },
                    {
                        id: '3',
                        type: 'transfer',
                        priority: 3,
                        duration: 30,
                        children: 2,
                        adults: 5,
                        text: 'Commit feature #1 to the repository'
                    },
                    {
                        id: '4',
                        type: 'transfer',
                        priority: 4,
                        duration: 30,
                        children: 2,
                        adults: 5,
                        text: 'Deploy the feature #1'
                    },
                    {
                        id: '5',
                        type: 'transfer',
                        priority: 5,
                        duration: 30,
                        children: 2,
                        adults: 5,
                        text: 'Build the demo app'
                    }
                ]
            },
            {
                priority: '2',
                name: 'Setting Up',
                items: [ // prettier-ignore
                    {
                        id: '11',
                        type: 'transfer',
                        priority: 1,
                        duration: 30,
                        children: 2,
                        adults: 5,
                        text: 'gdb dghbdg dges #1'
                    },
                    {
                        id: '12',
                        type: 'transfer',
                        priority: 2,
                        duration: 30,
                        children: 2,
                        adults: 5,
                        text: 'fgbed egfves #1'
                    },
                    {
                        id: '13',
                        type: 'transfer',
                        priority: 3,
                        duration: 30,
                        children: 2,
                        adults: 5,
                        text: 'gedt rsgasr gv'
                    },
                    {
                        id: '14',
                        type: 'transfer',
                        priority: 4,
                        duration: 30,
                        children: 2,
                        adults: 5,
                        text: 'rged rasfgv#1'
                    },
                    {
                        id: '15',
                        type: 'transfer',
                        priority: 5,
                        duration: 30,
                        children: 2,
                        adults: 5,
                        text: 'rasgesgd esrgae wrg'
                    }
                ]
            },
            {
                priority: '3',
                name: 'Departure',
                items: [ // prettier-ignore
                    {
                        id: '13',
                        type: 'transfer',
                        priority: 1,
                        duration: 30,
                        children: 2,
                        adults: 5,
                        text: 'gdb dghbdg dges #3'
                    },
                    {
                        id: '13',
                        type: 'transfer',
                        priority: 2,
                        duration: 30,
                        children: 2,
                        adults: 5,
                        text: 'fgbed egfves #3'
                    }
                ]
            }
        ]
    }
