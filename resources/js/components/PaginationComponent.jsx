import React from 'react';
import Pagination from '@mui/material/Pagination';

export default function PaginationComponent({ page = 1 }) {
    const handlePagination = (event, value) => {
        console.log(value);
    };

    return (
        <>
            {page > 5 && (
                <div>
                    <Pagination
                        count={page}
                        defaultPage={1}
                        siblingCount={2}
                        onChange={handlePagination}
                    />
                </div>
            )}
        </>
    );
}
