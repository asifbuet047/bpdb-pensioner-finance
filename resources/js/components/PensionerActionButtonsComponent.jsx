import DeleteIcon from '@mui/icons-material/Delete';
import EditIcon from '@mui/icons-material/Edit';
import ArrowForwardIcon from '@mui/icons-material/ArrowForward';
import ArrowBackIcon from '@mui/icons-material/ArrowBack';
import DoneOutlineIcon from '@mui/icons-material/DoneOutline';
import Tooltip from '@mui/material/Tooltip';

const ACTIONS = {
    delete: {
        icon: <DeleteIcon fontSize="small" />,
        title: 'Delete Pensioner',
    },
    edit: { icon: <EditIcon fontSize="small" />, title: 'Edit Pensioner' },
    forward: { icon: <ArrowForwardIcon fontSize="small" />, title: 'Forward' },
    forwardApproval: {
        icon: <ArrowForwardIcon fontSize="small" />,
        title: 'Forward for Approval',
    },
    back: {
        icon: <ArrowBackIcon fontSize="small" />,
        title: 'Return Pensioner',
    },
    backToCertifier: {
        icon: <ArrowBackIcon fontSize="small" />,
        title: 'Return Pensioner to Certifier',
    },
    approve: { icon: <DoneOutlineIcon fontSize="small" />, title: 'Approve' },
};

const RULES = {
    initiator: {
        initiated: ['delete', 'edit', 'forward'],
        certified: ['back', 'forwardApproval'],
        approved: ['backToCertifier', 'approve'],
    },
    certifier: {
        initiated: ['delete', 'edit', 'forward'],
        certified: ['back', 'forwardApproval'],
        approved: ['backToCertifier', 'approve'],
    },
    approver: {
        initiated: ['delete', 'edit', 'forward'],
        certifier: ['back', 'forwardApproval'],
        approved: ['backToCertifier', 'approve'],
    },
};

export default function PensionerActionButtonsComponent({ officerRole, pensionersType }) {
    const actions = RULES[officerRole]?.[pensionersType] || [];

    return (
        <div className="d-flex gap-2 justify-content-center">
            {actions.map((key) => {
                const { icon, title } = ACTIONS[key];

                const disabled = officerRole !== 'initiator' || pensionersType !== 'initiated';

                return (
                    <button
                        key={key}
                        className="custom-button-fill"
                        disabled={disabled && key !== 'back' && key !== 'forwardApproval'}
                    >
                        <Tooltip title={title}>{icon}</Tooltip>
                    </button>
                );
            })}
        </div>
    );
}
