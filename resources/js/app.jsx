import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import axios from 'axios';
import './helper';
import '../css/app.css';
import { createRoot } from 'react-dom/client';
import * as bootstrap from 'bootstrap';

import NotificationComponent from './components/NotificationComponent';
import DeleteButtonComponent from './components/DeleteButtonComponent';
import EditButtonComponent from './components/EditButtonComponent';
import ForwardButtonComponent from './components/ForwardButtonComponent';
import ReturnButtonComponent from './components/ReturnButtonComponent';
import ApproveButtonComponent from './components/ApproveButtonComponent';
import UpdateSuccessSnackbar from './components/UpdateSuccessSnackbar';
import WorkflowButtonComponent from './components/WorkflowButtonComponent';
import MonthlyGeneratePensionComponent from './components/MonthlyGeneratePensionComponent';
import PensionersPensionBlockButtonComponent from './components/PensionersPensionBlockButtonComponent';
import CertifierGeneratedPensionButtonComponent from './components/CertifierGeneratedPensionButtonComponent';
import InitiatorGeneratedPensionButtonComponent from './components/InitiatorGeneratedPensionButtonComponent';
import ApproverGeneratedPensionButtonComponent from './components/ApproverGeneratedPensionButtonComponent';
import PensionDeleteButtonComponent from './components/PensionDeleteButtonComponent';
import PensionForwardButtonComponent from './components/PensionForwardButtonComponent';
import PensionReturnButtonComponent from './components/PensionReturnButtonComponent';
import PensionApproveButtonComponent from './components/PensionApproveButtonComponent';
import PensionWorkflowButtonComponent from './components/PensionWorkflowButtonComponent';
import PensionDashboardButtonComponent from './components/PensionDashboardButtonComponent';
import PrintButtonComponent from './components/PrintButtonComponent';
import PaginationComponent from './components/PaginationComponent';

axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.bootstrap = bootstrap;

const el = document.getElementById('notification');
if (el) {
    console.log('React notification is successfully integrated');
    createRoot(el).render(<NotificationComponent />);
} else {
    console.log('React integration into react-app element failed');
}

document.querySelectorAll('.pensioner-update-button').forEach((el) => {
    createRoot(el).render(
        <EditButtonComponent
            pensionerId={el.dataset.pensionerId}
            pensionerName={el.dataset.pensionerName}
            buttonStatus={el.dataset.buttonStatus}
        />,
    );
});

document.querySelectorAll('.pensioner-delete-button').forEach((el) => {
    createRoot(el).render(
        <DeleteButtonComponent
            pensionerId={el.dataset.pensionerId}
            pensionerName={el.dataset.pensionerName}
            buttonStatus={el.dataset.buttonStatus}
        />,
    );
});

document.querySelectorAll('.pensioner-forward-button').forEach((el) => {
    createRoot(el).render(
        <ForwardButtonComponent
            pensionerId={el.dataset.pensionerId}
            pensionerName={el.dataset.pensionerName}
            buttonStatus={el.dataset.buttonStatus}
        />,
    );
});

document.querySelectorAll('.pensioner-return-button').forEach((el) => {
    createRoot(el).render(
        <ReturnButtonComponent
            pensionerId={el.dataset.pensionerId}
            pensionerName={el.dataset.pensionerName}
            buttonStatus={el.dataset.buttonStatus}
        />,
    );
});

document.querySelectorAll('.pensioner-approve-button').forEach((el) => {
    createRoot(el).render(
        <ApproveButtonComponent
            pensionerId={el.dataset.pensionerId}
            pensionerName={el.dataset.pensionerName}
            buttonStatus={el.dataset.buttonStatus}
        />,
    );
});

document.querySelectorAll('.pensioner-workflow-button').forEach((el) => {
    createRoot(el).render(
        <WorkflowButtonComponent
            pensionerId={el.dataset.pensionerId}
            pensionerName={el.dataset.pensionerName}
        />,
    );
});

document.querySelectorAll('.pensioner-block-checkbox').forEach((el) => {
    createRoot(el).render(
        <PensionersPensionBlockButtonComponent
            pensionerId={el.dataset.pensionerId}
            pensionerName={el.dataset.pensionerName}
        />,
    );
});

const snackbarEl = document.getElementById('update-success-snackbar');

if (snackbarEl) {
    createRoot(snackbarEl).render(<UpdateSuccessSnackbar />);
}

const monthlyPension = document.getElementById('monthly-pension-generation');
if (monthlyPension) {
    createRoot(monthlyPension).render(<MonthlyGeneratePensionComponent />);
}

const certifierPensionButton = document.getElementById('certifier-pension-button');
if (certifierPensionButton) {
    createRoot(certifierPensionButton).render(
        <CertifierGeneratedPensionButtonComponent
            pensionId={certifierPensionButton.dataset.pensionId}
        />,
    );
}

const initiatorPensionButton = document.getElementById('initiator-pension-button');
if (initiatorPensionButton) {
    createRoot(initiatorPensionButton).render(
        <InitiatorGeneratedPensionButtonComponent
            pensionData={initiatorPensionButton.dataset.pensionData}
        />,
    );
}

const approverPensionButton = document.getElementById('approver-pension-button');

if (approverPensionButton) {
    createRoot(approverPensionButton).render(
        <ApproverGeneratedPensionButtonComponent
            pensionId={approverPensionButton.dataset.pensionId}
        />,
    );
}

document.querySelectorAll('.pension-delete-button').forEach((el) => {
    createRoot(el).render(
        <PensionDeleteButtonComponent
            pensionId={el.dataset.pensionId}
            totalAmount={el.dataset.totalAmount}
            buttonStatus={el.dataset.buttonStatus}
        />,
    );
});

document.querySelectorAll('.pension-forward-button').forEach((el) => {
    createRoot(el).render(
        <PensionForwardButtonComponent
            pensionId={el.dataset.pensionId}
            totalAmount={el.dataset.totalAmount}
            buttonStatus={el.dataset.buttonStatus}
        />,
    );
});

document.querySelectorAll('.pension-return-button').forEach((el) => {
    createRoot(el).render(
        <PensionReturnButtonComponent
            pensionId={el.dataset.pensionId}
            totalAmount={el.dataset.totalAmount}
            buttonStatus={el.dataset.buttonStatus}
        />,
    );
});

document.querySelectorAll('.pension-approve-button').forEach((el) => {
    createRoot(el).render(
        <PensionApproveButtonComponent
            pensionId={el.dataset.pensionId}
            totalAmount={el.dataset.totalAmount}
            buttonStatus={el.dataset.buttonStatus}
        />,
    );
});

document.querySelectorAll('.pension-workflow-button').forEach((el) => {
    createRoot(el).render(
        <PensionWorkflowButtonComponent
            pensionId={el.dataset.pensionId}
            totalAmount={el.dataset.totalAmount}
        />,
    );
});

document.querySelectorAll('.pension-dashboard-button').forEach((el) => {
    createRoot(el).render(<PensionDashboardButtonComponent pensionId={el.dataset.pensionId} />);
});

document.querySelectorAll('.print-button').forEach((el) => {
    createRoot(el).render(<PrintButtonComponent pensionId={el.dataset.pensionId} />);
});

document.querySelectorAll('.pagination-view-pensioner').forEach((el) => {
    createRoot(el).render(<PaginationComponent page={el.dataset.pageCount} />);
});
