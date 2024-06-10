import { Box, Modal } from '@mui/material'
import axios from 'axios';
import React, { useEffect, useState } from 'react'
import { baseUrl } from '../../define/variables';
import { Badge, ChakraProvider, Circle, Flex, Icon, Spacer, Stack, Text } from '@chakra-ui/react';
import { faEllipsis, faStar } from '@fortawesome/free-solid-svg-icons';
function CustomerProfile({ open, setOpen, customerId }) {
    const [customer, setCustomer] = useState({});
    const style = {
        position: 'absolute',
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        width: "70%",
        bgcolor: '#0d1c2e',
        boxShadow: 24,
        height: 'calc(100vh - 150px)',
    };

    useEffect(() => {
        if (customerId) {
            axios.get(baseUrl + 'customer/' + customerId).then((res) => {
                setCustomer(res.data.customer);
            })
        }

    }, [customerId])

    console.log(customer);

    return (
        <Modal
            open={open}
            onClose={() => { setOpen(false) }}
            aria-labelledby="modal-modal-title"
            aria-describedby="modal-modal-description"
        >
            <Box sx={style}>
                <div className="row">
                    <div className="col-md-12">
                        <div className="row">
                            <div className="col-md-2 ">
                                <div className="avatar">
                                    <img className='w-100' src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png" alt="" />
                                </div>
                            </div>
                            <div className="col-md-10">
                                <div className="border-calls">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Box>
        </Modal>
    )
}
export default CustomerProfile