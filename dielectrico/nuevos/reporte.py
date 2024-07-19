import os
import pandas as pd
import matplotlib.pyplot as plt
from fpdf import FPDF
from sqlalchemy import create_engine

# Configuración de la conexión a la base de datos
db_config = {
    'user': 'root',
    'password': '',
    'host': 'localhost',
    'database': 'sistema_dielectricos2'
}

# Crear la cadena de conexión
db_url = f"mysql+pymysql://{db_config['user']}:{
    db_config['password']}@{db_config['host']}/{db_config['database']}"

# Conexión a la base de datos y extracción de datos


def get_data_from_db(query):
    engine = create_engine(db_url)
    data = pd.read_sql(query, engine)
    print(data.head())
    return data


def get_monthly_data(query):
    engine = create_engine(db_url)
    data = pd.read_sql(query, engine)
    print(data.head())
    return data


def create_monthly_chart(data, chart_path):
    plt.figure(figsize=(12, 8))

    if 'mes' in data.columns and 'cantidad' in data.columns:
        plt.bar(data['mes'], data['cantidad'], color='lightcoral')
        plt.title('Cantidad de Equipos por Mes del Año Actual', fontsize=14)
        plt.xlabel('Mes', fontsize=12)
        plt.ylabel('Cantidad', fontsize=12)
        plt.xticks(rotation=45, ha='right')
        plt.grid(axis='y', linestyle='--', alpha=0.7)
        plt.tight_layout()
        plt.savefig(chart_path)
        plt.close()
    else:
        print("Error: Las columnas 'mes' o 'cantidad' no se encuentran en los datos.")

# Generación del reporte en PDF


class PDF(FPDF):
    def header(self):
        self.set_font('Arial', 'B', 12)
        self.cell(0, 10, 'Reporte de Datos', 0, 1, 'C')
        self.ln(10)

    def footer(self):
        self.set_y(-15)
        self.set_font('Arial', 'I', 8)
        self.cell(0, 10, f'Página {self.page_no()}', 0, 0, 'C')

    def chapter_title(self, title):
        self.set_font('Arial', 'B', 12)
        self.cell(0, 10, title, 0, 1, 'L')
        self.ln(10)

    def chapter_body(self, body):
        self.set_font('Arial', '', 12)
        self.multi_cell(0, 10, body)
        self.ln()

    def add_monthly_chart(self, image_path):
        self.add_page()
        self.chapter_title('Cantidad de Equipos por Mes del Año Actual')
        self.add_image(image_path)

    def add_table(self, data):
        self.set_font('Arial', 'B', 10)
        col_width = self.w / (len(data.columns) + 1)
        row_height = self.font_size * 1.5

        for col in data.columns:
            self.cell(col_width, row_height, str(col), border=1)
        self.ln(row_height)

        self.set_font('Arial', '', 10)
        for row in data.itertuples():
            for item in row[1:]:
                self.cell(col_width, row_height, str(item), border=1)
            self.ln(row_height)

    def add_image(self, image_path):
        if os.path.exists(image_path):
            # Ajustar el ancho de la imagen para caber en la página
            self.image(image_path, x=10, y=None, w=190)
        else:
            self.chapter_body("Error: El gráfico no se pudo generar.")

# Generación de gráficos de barras


def create_chart(data, chart_path, x_col, y_col, title='Datos', xlabel='Cliente ID', ylabel='Cantidad'):
    plt.figure(figsize=(12, 8))

    if x_col in data.columns and y_col in data.columns:
        plt.bar(data[x_col].astype(str), data[y_col], color='skyblue')
        plt.title(title, fontsize=14)
        plt.xlabel(xlabel, fontsize=12)
        plt.ylabel(ylabel, fontsize=12)
        # Rotar las etiquetas del eje x para mayor legibilidad
        plt.xticks(rotation=45, ha='right')
        plt.grid(axis='y', linestyle='--', alpha=0.7)
        plt.tight_layout()  # Ajustar el diseño para evitar solapamientos
        plt.savefig(chart_path)
        plt.close()
    else:
        print(f"Error: Las columnas {x_col} o {
              y_col} no se encuentran en los datos.")

# Generación del reporte para múltiples tablas


def generate_report_for_tables(tables, output_path):
    # Crear el directorio si no existe
    os.makedirs(os.path.dirname(output_path), exist_ok=True)

    pdf = PDF()
    # Obtener datos mensuales y crear gráfico
    monthly_query = """
    SELECT 
        MONTH(fecha) AS mes, 
        COUNT(*) AS cantidad 
    FROM 
        orden_item 
    WHERE 
        YEAR(fecha) = YEAR(CURDATE()) 
    GROUP BY 
        MONTH(fecha) AND equipo
    ORDER BY 
        mes
    """
    monthly_data = get_monthly_data(monthly_query)
    monthly_chart_path = os.path.join(
        os.path.dirname(output_path), 'monthly_chart.png')
    create_monthly_chart(monthly_data, monthly_chart_path)

    for table_info in tables:
        query = table_info['query']
        data = get_data_from_db(query)

        # Crear gráfico
        chart_path = os.path.join(os.path.dirname(output_path), f"{
                                  table_info['name']}_chart.png")
        create_chart(data, chart_path, table_info['x_col'], table_info['y_col'],
                     table_info['title'], table_info['xlabel'], table_info['ylabel'])

        # Añadir contenido al PDF
        pdf.add_page()
        pdf.chapter_title(f"Tabla de Datos - {table_info['name']}")
        pdf.add_table(data)
        pdf.chapter_title(f"Gráfico de Datos - {table_info['name']}")
        pdf.add_image(chart_path)

    pdf.output(output_path)


# Ejemplo de uso
if __name__ == "__main__":
    tables = [

        {
            'name': 'Cantidad Guantes',
            'query': "SELECT empresa, COUNT(*) AS cantidad FROM orden_item WHERE equipo = 'Guantes' AND YEAR(fecha) = YEAR(CURDATE()) GROUP BY empresa ORDER BY cantidad DESC LIMIT 10",
            'x_col': 'empresa',
            'y_col': 'cantidad',
            'title': 'Top 10 Clientes y Cantidad de pares de Guantes vendidos',
            'xlabel': 'Empresas',
            'ylabel': 'Cantidad'
        },
        {
            'name': 'Cantidad Mantas',
            'query': "SELECT empresa, COUNT(*) AS cantidad FROM orden_item WHERE equipo = 'Mantas' AND YEAR(fecha) = YEAR(CURDATE()) GROUP BY empresa ORDER BY cantidad DESC LIMIT 10",
            'x_col': 'empresa',
            'y_col': 'cantidad',
            'title': 'Top 10 Clientes y Cantidad de Mantas vendidas',
            'xlabel': 'Empresas',
            'ylabel': 'Cantidad'
        },
        {
            'name': 'Cantidad Banquetas',
            'query': "SELECT empresa, COUNT(*) AS cantidad FROM orden_item WHERE equipo = 'Banquetas' AND YEAR(fecha) = YEAR(CURDATE()) GROUP BY empresa ORDER BY cantidad DESC LIMIT 10",
            'x_col': 'empresa',
            'y_col': 'cantidad',
            'title': 'Top 10 Clientes y Cantidad Banquetas vendidas',
            'xlabel': 'Empresas',
            'ylabel': 'Cantidad'
        }
    ]
    output_path = 'dielectrico/nuevos/pdfs/reporte.pdf'
    generate_report_for_tables(tables, output_path)
